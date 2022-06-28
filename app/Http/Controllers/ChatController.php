<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Verifica que exista algun chat entre los dos usuarios y si no, crea uno nuevo para estos dos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chatWith(User $user)
    {

        $user_a = auth()->user();
        $user_b = $user;
        $chat = $user_a->chats()->wherehas('users', function ($q) use ($user_b) {
            $q->where('chat_user.user_id', $user_b->id);
        })->first();

        if (!$chat) {

            $chat = Chat::create([]);

            $chat->users()->sync([$user_a->id, $user_b->id]);
        }

        return redirect()->route('chat.show', $chat);
    }

    /**
     * redirecciona al usuario al chat correspondiente, si el usuario no pertenece a
     * este chat obtendra un error 403 de acceso denegado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        abort_unless($chat->users->contains(auth()->user()->id), 403);

        return view('chat', [
            'chat' => $chat
        ]);
    }

    /**
     * Se obtienen los usuarios relacionados al chat.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Chat $chat)
    {
        $users = $chat->users;

        return response()->json(['users' => $users]);
    }

    /**
     * Se obtienen los mensajes relacionados al chat.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMessages(Chat $chat)
    {
        $messages = $chat->messages()->with('user')->get();

        return response()->json(['messages' => $messages]);
    }
}
