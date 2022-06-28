@extends('adminlte::page')

@section('title', 'Servicios')

@section('content_header')
<h1>Servicios</h1>
@stop

@section('content')
<div class="pr-5 d-flex justify-content-end">
  <a class="btn btn-primary" href="{{ route('admin.services.create') }}">{{ __('Create service') }}</a>
</div>
<div class="pt-5">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <!-- Tabla para visualizar la información de los servicios -->
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Autor</th>
        <th scope="col">Ciudad</th>
        <th scope="col">Fecha Publicación</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($services as $service)
      <tr>
        <th scope="row">{{ $service->id }}</th>
        <td>{{ $service->name }}</td>
        <td>{{ $service->user->name }}</td>
        <td>{{ $service->city->name }}</td>
        <td>{{ $service->created_at }}</td>
        <td>
          <a class="btn btn-primary" href="{{ route('admin.services.show', $service) }}">Ver</a>
          <a class="btn btn-warning" href="{{ route('admin.services.edit', $service) }}">Editar</a>
          <form action="{{ route('admin.services.destroy', $service) }}" method="post" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger text-white" onclick="return confirm('Deseas borrar tu servicio?')">{{__('Delete')}}</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="d-flex align-items-center justify-content-center">
  {{ $services->links() }}
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
  console.log('Hi!');
</script>
@stop
