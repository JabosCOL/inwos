@extends('layouts.app')
@section('content')
<div class="container pt-5">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <h1>Historial de ordenes</h1>
  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Servicio</th>
        <th scope="col">Cliente</th>
        <th scope="col">Fecha</th>
        <th scope="col">Hora</th>
        <th scope="col">Precio</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
      <tr>
        <td>{{ $order->service->name }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->date }}</td>
        <td>{{ $order->time }}</td>
        <td>$ {{ $order->service->price }}</td>
        <td>{{ $order->status }}</td>
        <td>
          <a class="btn btn-light" href="{{ route('order.show', $order) }}">Ver</a>
          @if (Auth::user()->id == $order->service->user_id)
          <form action="{{ route('order.accept', $order)}}" method="post" class="d-inline">
            @csrf
            <input type="text" name="status" value="aceptado" hidden>
            <div class="disabled-wrapper"><button class="btn btn-primary text-white {{ $order->status == 'aceptado' || $order->status == 'cancelado' || $order->status == 'finalizado'? 'disabled' : '' }}" onclick="return confirm('Deseas aceptar el servicio {{$order->service->name}}?')">{{__('Accept')}}</button></div>
          </form>
          <form action="{{ route('order.finish', $order)}}" method="post" class="d-inline">
            @csrf
            <input type="text" name="status" value="finalizado" hidden>
            <div class="disabled-wrapper"><button class="btn btn-warning text-white {{ $order->status == 'cancelado' || $order->status == 'finalizado'? 'disabled' : '' }}" onclick="return confirm('Deseas finalizar el servicio {{$order->service->name}}?')">{{__('Finish')}}</button></div>
          </form>
          @endif
          <form action="{{ route('order.cancel', $order)}}" method="post" class="d-inline">
            @csrf
            <input type="text" name="status" value="cancelado" hidden>
            <div class="disabled-wrapper"><button class="btn btn-danger text-white {{ $order->status == 'cancelado' || $order->status == 'finalizado'? 'disabled' : '' }}" onclick="return confirm('Deseas cancelar esta orden del servicio {{$order->service->name}}?')">{{__('Cancel')}}</button></div>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="d-flex align-items-center justify-content-center">
  {{ $orders->links() }}
</div>
@endsection
