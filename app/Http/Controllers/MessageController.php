<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Recibe el request para almacenar los mensajes y adicionalmente crea la notificación,
     * en caso de que ya exista una actualizara la hora del envio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sent(Request $request)
    {
        $message = new Message();
        $message->user_id = auth()->user()->id;
        $message->chat_id = $request->chat_id;
        $message->content = $request->message;
        $message->save();
        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        $Usermessages = DB::table('notifications')
            ->where('type', '=', 'App\Notifications\MessageNotification')
            ->whereJsonContains('data->user_id', auth()->user()->id)
            ->whereJsonContains('data->chat_id', strval($request->chat_id))
            ->update(['created_at' => Carbon::now()]);

        if ($Usermessages == NULL) {
            $chat_users = DB::table('chat_user')->where('chat_id', '=', $request->chat_id)->pluck('user_id');

            $notify_user = User::WhereIn('id', $chat_users)->get()->except(auth()->user()->id);

            $notify_user[0]->notify(new MessageNotification($message));
        }

        return $message;
    }
}
