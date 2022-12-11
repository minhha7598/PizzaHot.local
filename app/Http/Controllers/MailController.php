<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\mailJob;

class MailController extends Controller
{
    public function sendEmail(Request $request) {
        try{         
            $input = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
            ]);
                        
            //QUEUE
            dispatch(new mailJob($input['name'], $input['email'])) ;      

            return response()->json([
                'status' => 'True',
                'message' => "Sent mail successfully!",
                'data' => 'No data!',
                'error' => 'false'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Sent mail failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        } 
    } 
}