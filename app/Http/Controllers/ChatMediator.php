<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatMediator extends Controller
{
    public function receiver(Request $request)
    {
        if (request()->ajax())
        {
            $user = $request->user;
            $user_msg = $request->message;
            
            $this->websocket($user, $user_msg);
        }
    }

    private function websocket($user, $user_msg) {
        event(new \App\Events\SendMessage($user, $user_msg));
    }
}
