<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use App\Notifications\OrderCreateNotification;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead($id)
    {
        $user = User::findOrFail($id);
        $user->unreadNotifications->map(function ($n) {
            $n->delete();
        });
        return redirect()->back()
        ->with('status', __('All notifications have been marked as read'));
    }

    /**
     * Change status to accepted.
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
     * Change status to finished.
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
     * Change status to canceled.
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
