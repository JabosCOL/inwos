@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container pt-3">
  <form action="{{ route('admin.services.store') }}" method="post" enctype="multipart/form-data">
    @include('admin.services._form', ['btnText'=>__('Create'), 'Text'=>__('Create new service')])
    <div class="pt-4">
      <a class="btn btn-primary col-3" href="{{ route('admin.services.index') }}">{{ __('Return') }}</a>
    </div>
  </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@stop
