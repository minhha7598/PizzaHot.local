<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function updateDeviceToken(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            Auth::user()->device_token = $request->input('device_token');
            Auth::user()->save();
//            $userRecord = User::Where('id', 1)->first();
//            $userRecord->device_token = $request->input('device_token');
//            $userRecord->save();
            return response()->json([
                'status' => 'True',
                'message' => "Token successfully stored!",
                'data' => 'No data!',
                'error' => 'False',
            ],200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Token failed stored!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    public function sendNotification(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            //Send many devices - GROUP
            $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

            $SERVER_API_KEY = env('FCM_SERVER_KEY');

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $request->input("title"),
                    "body" => $request->input("body")
                ]
            ];

            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            //1. Khởi tạo cURL
            $ch = curl_init();

            //2. Thiết lập tùy chọn request
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            //3. Thực thi
            $response = curl_exec($ch);

            //4. Close connection
            curl_close($ch);

            return response()->json([
                'status' => 'True',
                'message' => "Push notification successfully!",
                'data' => $response,
                'error' => 'False',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Push notification failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ], 404);
        }
    }
}
