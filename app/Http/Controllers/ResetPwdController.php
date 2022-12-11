<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Mail\SendMailReset;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\EmailRequest;

class ResetPwdController extends Controller
{
    public function sendEmail(EmailRequest $request)  
    {
        try{
            $email = $request->email;
            
            //Check Exits Email
            $existEmailRecord = User::where('email', $email)->first();
            if (!$existEmailRecord){ 
                return response()->json([
                    'status' => 'False',
                    'message' => 'Email does not exist!',
                    'data' => 'No data!',
                    'error' => 'True'
                ],422);
            }

            $token = Str::random(40);
            
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
    
            Mail::to($email)
                ->send(new SendMailReset($token, $email));  
                
            return response()->json([
                'status' => 'True',
                'message' => 'Please check email!',
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Send email to reset password failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }                     
    }


    //UPDATE PASSWORD
    public function updatePassword(UpdatePasswordRequest $request){
        try{
            $email_data = DB::table('password_resets')->where([
                'email' => $request->Email,
                'token' => $request->Token
            ]);

            if($email_data->count() > 0 )
            {
                User::whereEmail($request->email)
                    ->first()
                    ->update([
                        'password'=>bcrypt($request->password)
                    ]);         
                $email_data->delete();
            }else{
                return response()->json([
                    'status' => 'Fasle',
                    'message' => 'Wrong token!',
                    'data' => 'No data!',
                    'error' => 'True'
                ],422); 
            }
            
            return response()->json([
                'status' => 'True',
                'message' => 'Change password successfully!',
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e){
            return response()->json([
                'status' => 'False',
                'message' => "Change password failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}