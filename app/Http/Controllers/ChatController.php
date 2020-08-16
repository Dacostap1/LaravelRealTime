<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\SaludoSent;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        return view('chat.show');
    }
    
    public function store(Request $request){
        $rules = [
            'message' => 'required',
        ];

        $request->validate($rules);

        broadcast(new MessageSent($request->user(), $request->message));

        return response()->json('Message broadcast');
    }

    public function saludo(Request $request, User $user){

        broadcast(new SaludoSent($user, "{$request->user()->name} te envió un saludo"));
        broadcast(new SaludoSent($request->user(), "Saludaste a {$user->name}"));

        return "Saludando a {$user->name} desde {$request->user()->name}";
    }
}
