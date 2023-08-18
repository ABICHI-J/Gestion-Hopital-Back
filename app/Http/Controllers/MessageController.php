<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function formMessagesSend()
    {
        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)->get();

        return view('send_message_form', compact('users'));
    }
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'to_user_id' => 'required',
            'message' => 'required|string',
        ]);

        $message = new Message([
            'from_user_id' => $user->id,
            'to_user_id' => $validated['to_user_id'],
            'message' => $validated['message'],
        ]);

        $message->save();

        return response()->json(['message' => 'Message envoyé avec succès.', 'data' => $message]);
    }

    public function getMessages(Request $request)
    {
        $user = Auth::user();
        $toUserId = $request->input('to_user_id');

        $messages = Message::where(function ($query) use ($user, $toUserId) {
            $query->where('from_user_id', $user->id)
                ->where('to_user_id', $toUserId);
        })->orWhere(function ($query) use ($user, $toUserId) {
            $query->where('from_user_id', $toUserId)
                ->where('to_user_id', $user->id);
        })->get();

        return response()->json(['messages' => $messages]);
    }
}
