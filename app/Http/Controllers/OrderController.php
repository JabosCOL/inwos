<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;

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
                            ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->service_id = request('service_id');
        $order->date = request('date');
        $order->time = request('time');
        $order->save();
        return redirect()->route('home')
        ->with('status', __('The service has been order!'));
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
        return redirect()->back()
        ->with('status', __('The order has been canceled'));
    }
}
