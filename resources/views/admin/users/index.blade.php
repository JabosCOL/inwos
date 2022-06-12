@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1>Usuarios</h1>
@stop

@section('content')
<div class="pt-5">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre de usuario</th>
        <th scope="col">Email</th>
        <th scope="col">Rol</th>
        <th scope="col">Fecha creación</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <th scope="row">{{ $user->id }}</th>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role->name }}</td>
        <td>{{ $user->created_at->diffForHumans() }}</td>
        <td>
          <a class="btn btn-warning" href="{{ route('admin.users.edit', $user) }}">Editar</a>
          <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger text-white" onclick="return confirm('Deseas borrar el usuario {{$user->name}}?')">{{__('Delete')}}</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="d-flex align-items-center justify-content-center">
  {{ $users->links() }}
</div>
@stop
