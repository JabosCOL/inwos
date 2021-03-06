@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('service.store') }}" method="post" enctype="multipart/form-data">
        @include('partials.servicesForm', ['btnText'=>__('Create'), 'Text'=>__('Create new service'), 'route'=>'service.edit'])
        <div class="pt-4">
            <a class="btn btn-primary col-3" href="{{ route('home') }}">{{ __('Return') }}</a>
        </div>
    </form>
</div>

@endsection
