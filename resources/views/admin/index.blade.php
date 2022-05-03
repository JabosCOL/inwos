@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<style>
  .content-wrapper {
    background-image: linear-gradient(rgba(16, 16, 16, .2), rgba(16, 16, 16, .8)), url(/storage/images/inwos/admin.jpg);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .background {
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
<div class="background">
  <img class="img" src="/storage/images/inwos/adminlogo.png" alt="inwos" width="60%">
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop
