@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container pt-3">
  <form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <div class="card text-center">
      <div class="card-header">
        <h4>Editar usuario</h4>
      </div>
      <div class="card-body">
        <div>
          @if(Auth::user()->image)
          <img src="/storage/{{ $user->image }}" class="rounded-circle border mt-2" alt="{{ $user->name }}" style="width:25%;">
          @else
          <img src="/storage/images/users/default.png" class="rounded-circle border mt-2" alt="default" style="width:25%;">
          @endif
          <div>
            <label for="name" class="form-label">{{__('Name')}}</label>
            <input type="text" name="name" class="form-control text-center mx-auto" style="width: 40% ;" id="name" placeholder="{{ __('Insert the username') }}" value="{{ old('name', $user->name) }}">
            {{ $errors->first('name') }}
          </div>
          <div class="pt-3">
            <label for="role" class="form-label">{{__('Role')}}</label><br>
            <select class="form-select text-center" id="role" name="role">
              <option value="">{{ __('Choose the rol') }}</option>
              @foreach ($roles as $id => $name)
              <option value="{{ $id }}" {{ $id == $user->role_id ? "selected" : '' }}>{{ $name }}</option>
              @endforeach
            </select>
            {{ $errors->first('role') }}
          </div>
        </div>
      </div>
      <div class="card-footer text-muted pb-3 pt-3">
        <button class="btn btn-primary col-md-6" type="submit">Editar</button>
      </div>
  </form>
  <div class="card-footer text-muted pb-3 pt-3">
    <form action="{{ route('user.deleteImage', $user) }}" method="post" class="d-inline">
      @csrf @method('PATCH')
      <button class="btn btn-danger text-white col-md-6" onclick="return confirm('Estas seguro de borrar tu foto?')">{{__('Delete photo')}}
      </button>
    </form>
  </div>
</div>
<div class="pt-4">
  <a class="btn btn-primary col-3" href="{{ route('admin.users.index') }}">{{ __('Return') }}</a>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop
