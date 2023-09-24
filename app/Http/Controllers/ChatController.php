<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(){
        $user= User::find(Auth::id());
        $message='ok';
        event(new ChatEvent($message,$user));
    }
}
