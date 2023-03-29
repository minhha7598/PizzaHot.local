<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use Facebook;

class SocialiteController extends Controller
{
    //GOOGLE
    public function googleLogin (): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            //Redirect -> Google FORM
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_CALLBACK_URL'));
            $client->addScope("email");
            $client->addScope("profile");
            $authUrl = $client->createAuthUrl();

            return redirect($authUrl);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get Google user data!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    public function googleCallback (): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            //Config
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_CALLBACK_URL'));
            $authUrl = $client->createAuthUrl();

            //Check respone Token form Google
            if (isset($_GET['code'])) {
                $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($accessToken);

                $google_oauthV2 = new Google_Service_Oauth2($client);
                $gpUserProfile = $google_oauthV2->userinfo->get();

                // Getting user profile info
                $gpUserData = array();
                $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
                $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
                $gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
                $gpUserData['email']       = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';

                //Check isset
                $user = User::Where('provider', 'GOOGLE')
                    ->Where('provider_uid', $gpUserData['oauth_uid'])
                    ->first();

                if (!$user){
                    $user = new User();
                    $user->name = $gpUserData['last_name'].' '.$gpUserData['first_name'];
                    $user->email =  $gpUserData['email'];
                    $user->provider = 'GOOGLE';
                    $user->provider_uid = $gpUserData['oauth_uid'] ;
                    $user->save();

                    $userRecord = User::Where('provider_uid', $gpUserData['oauth_uid'])->first();

                    return response()->json([
                        'status' => 'True',
                        'message' => "Get Google user data successfuly!",
                        'data' => $userRecord,
                        'error' => 'False'
                    ],200);
                }
            }
            if(!isset($_GET['code'])){
                return redirect($authUrl);
            }
            //return redirect('/myDomain.com');
            return response()->json([
                'status' => 'True',
                'message' => "Get Google user data successfuly!",
                'data' => $user,
                'redirect' => 'myDomain.com',
                'error' => 'False'
            ],200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get Google user data!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    public function googleLogout (Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            //Config
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_CALLBACK_URL'));

            $accessToken = $request->input("token");
            $client->revokeToken($accessToken);

            return redirect("https://www.google.com.vn/?hl=vi");
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Logout Facebook failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    //FACEBOOK
    public function facebookLogin (): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            //Redirect -> FaceBook FORM
            $fb = new Facebook\Facebook([
                'app_id' => env('FACEBOOK_CLIENT_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v2.10',
            ]);

            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(env('FACEBOOK_CALLBACK_URL'), $permissions);

            return redirect($loginUrl);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get Facebook user data!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    public function facebookCallback ()
    {
        try{
            //Config
            $fb = new Facebook\Facebook([
                'app_id' => env('FACEBOOK_CLIENT_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v2.10',
            ]);
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(env('FACEBOOK_CALLBACK_URL'), $permissions);

            //Check state (serve generate to keep login process)
            if (isset($_GET['state'])) {
                $helper->getPersistentDataHandler()->set('state', $_GET['state']);
            }

            //Check code to Get accessToken
            if(isset($_GET['code'])){
                try {
                    $accessToken = $helper->getAccessToken();
                    // dd($accessToken);
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            }else{
                return redirect($loginUrl);
            }

            //Get Facebook data
            try {
                $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,cover,picture', $accessToken);
                $fbUserProfile = $profileRequest->getGraphNode()->asArray();
            } catch(FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                // Redirect user back to app login page
                header("Location: ./");
                exit;
            } catch(FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            //Check isset user DB
            $user = User::Where('provider', 'FACEBOOK')
                ->Where('provider_uid', $fbUserProfile['id'])
                ->first();

            //!isset -> Insert users and reuturn
            if (!$user){
                $user = new User();
                $user->name = $fbUserProfile['name'];
                $user->email =  $fbUserProfile['email'];
                $user->provider = 'FACEBOOK';
                $user->provider_uid = $fbUserProfile['id'] ;
                $user->save();

                $userRecord = User::Where('provider', 'FACEBOOK')
                    ->Where('provider_uid', $fbUserProfile['id'])
                    ->first();

                return response()->json([
                    'status' => 'True',
                    'message' => "Get Facebook user data successfully!",
                    'data' => $userRecord,
                    'redirect' => 'myDomain.com',
                    'error' => 'False'
                ],200);
            }

            //return redirect('/myDomain.com');
            return response()->json([
                'status' => 'True',
                'message' => "Get Facebook user data successfuly!",
                'data' => $user,
                'redirect' => 'myDomain.com',
                'error' => 'False'
            ],200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get Facebook user data!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    public function facebookLogout(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            $fb = new Facebook\Facebook([
                'app_id' => env('FACEBOOK_CLIENT_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v2.10',
            ]);

            $helper = $fb->getRedirectLoginHelper();
            $accessToken = $request->input("token");

            $myDomain = $helper->getLogoutUrl($accessToken, "https://www.facebook.com/");

            return redirect($myDomain);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Logout Facebook failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }
}
