@extends('layouts.app')
@section('content')
<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-10 col-lg-8 col-xl-6">
      <div class="card card-stepper" style="border-radius: 16px;">
        <div class="card-header p-4">
          <h4>{{__('Order details')}}</h4>
        </div>
        <div class="card-body p-4">
          <div class="d-flex flex-row">
            <div class="flex-fill">
              <h5 class="bold pb-2">{{ $order->service->name }}</h5>
              <p class="text-muted"><strong>{{__('Client')}}:</strong> {{ $order->user->name }}</p>
              <p class="text-muted"><strong>{{__('Date')}}:</strong> {{ $order->date }}</p>
              <p class="text-muted"><strong>{{__('Time')}}:</strong> {{ $order->time }}</p>
              <p class="text-muted"><strong>{{__('Price')}}:</strong> ${{ number_format($order->service->price) }}</p>
              <p class="text-muted"><strong>{{__('Status')}}:</strong> {{ $order->status }}</p>
            </div>
            <div>
              <img class="d-flex align-items-center" src="/storage/{{ $order->service->image }}" alt="$order->service->name" style="width: 300px; height: 250px;">
            </div>
          </div>
        </div>
        <div class="card-footer p-4">
          <div class="d-flex justify-content-end">
            @if (Auth::user()->id == $order->service->user_id)
            <form action="{{ route('order.accept', $order)}}" method="post" class="d-inline">
              @csrf
              <input type="text" name="status" value="aceptado" hidden>
              <div class="disabled-wrapper"><button class="btn btn-primary text-white mr-2 {{ $order->status == 'aceptado' || $order->status == 'cancelado' || $order->status == 'finalizado'? 'disabled' : '' }}" onclick="return confirm('Deseas aceptar el servicio {{$order->service->name}}?')">{{__('Accept')}}</button></div>
            </form>
            <form action="{{ route('order.finish', $order)}}" method="post" class="d-inline">
              @csrf
              <input type="text" name="status" value="finalizado" hidden>
              <div class="disabled-wrapper"><button class="btn btn-warning text-white mr-2 {{ $order->status == 'cancelado' || $order->status == 'finalizado' || $order->status == 'en espera'? 'disabled' : '' }}" onclick="return confirm('Deseas finalizar el servicio {{$order->service->name}}?')">{{__('Finish')}}</button></div>
            </form>
            @endif
            <form action="{{ route('order.cancel', $order)}}" method="post" class="d-inline">
              @csrf
              <input type="text" name="status" value="cancelado" hidden>
              <div class="disabled-wrapper"><button class="btn btn-danger text-white mr-2 {{ $order->status == 'cancelado' || $order->status == 'finalizado'? 'disabled' : '' }}" onclick="return confirm('Deseas cancelar esta orden del servicio {{$order->service->name}}?')">{{__('Cancel')}}</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
