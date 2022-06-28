<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use App\Notifications\OrderCreateNotification;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra las ordenes asociadas a los servicios propios y al usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        $services_id = Service::where('user_id', '=', $user)->pluck('id');

        return view('orders.index', [
            'orders' => Order::where('user_id', '=', $user)
                            ->orWhereIn('service_id', $services_id)
                            ->paginate(10)
        ]);
    }

    /**
     * Recibe el request para crear una nueva order y crea la notificación correspondiente.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->validate([
            'date' => 'required',
            'time' => 'required',
        ]);

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->service_id = request('service_id');
        $order->date = request('date');
        $order->time = request('time');
        $order->save();
        User::find($order->service->user_id)->notify(new OrderCreateNotification($order));
        return redirect()->route('home')
        ->with('status', __('The service has been order!'));
    }

    /**
     * Muestra la vista detallada de la orden o de la encuesta en
     * caso de haber finalizado el servicio al dar click a la notificación
     * correspondiente, adicionalmente elimina la notificación.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, $notification = null, $service = null)
    {
        $notification = auth()->user()->notifications->find($notification);
        if ($notification) {
            $notification->delete();
        }
        if ($service){
            return view('surveys.create', [
                'service_id' => $service,
            ]);
        } else {
            return view('orders.show', [
                'order' => $order,
            ]);
        }
    }

    /**
     * Elimina todas las notificaciones dependiendo de su tipo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead($type)
    {
        if ($type == 'notification') {
            $notifications = DB::table('notifications')
                ->where('notifiable_id', auth()->user()->id)
                ->whereNotIn('type', ['App\Notifications\MessageNotification'])
                ->delete();

            return redirect()->back()
                ->with('status', __('All notifications have been marked as read'));

        } elseif ($type == 'message') {
            $messages = DB::table('notifications')
                ->where('notifiable_id', auth()->user()->id)
                ->where('type', '=', 'App\Notifications\MessageNotification')
                ->delete();

            return redirect()->back()
                ->with('status', __('All messages have been marked as read'));
        }
    }

    /**
     * Cambia el estado de la orden a aceptado y envia la notificación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Order $order)
    {
        $order->update(['status' => request('status')]);
        User::find($order->user_id)->notify(new OrderStatusNotification($order));
        return redirect()->back()
        ->with('status', __('The order has been accepted'));
    }

    /**
     * Cambia el estado de la orden a finalizado y envia la notificación.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finish(Order $order)
    {
        $order->update(['status' => request('status')]);
        User::find($order->user_id)->notify(new OrderStatusNotification($order));
        return redirect()->back()
        ->with('status', __('The order has been finished'));
    }

    /**
     * Cambia el estado de la orden a cancelado y envia la notificación.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        $order->update(['status' => request('status')]);
        if (auth()->user()->id == $order->user_id) {
            User::find($order->service->user_id)->notify(new OrderStatusNotification($order));
        } else {
            User::find($order->user_id)->notify(new OrderStatusNotification($order));
        }
        return redirect()->back()
        ->with('status', __('The order has been canceled'));
    }
}
