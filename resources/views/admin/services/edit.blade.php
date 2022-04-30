@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container pt-3">
  <form action="{{ route('admin.services.update', $service) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @include('admin.services._form', ['btnText'=>__('Edit'), 'Text'=>__('Edit service')])
    <div class="pt-4">
      <a class="btn btn-primary col-3" href="{{ route('admin.services.index', $service) }}">{{__('Return')}}</a>
    </div>
  </form>
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
