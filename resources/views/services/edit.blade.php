@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('service.update', $service) }}" method="post" enctype="multipart/form-data">
        @method('PATCH')
        @include('services._form', ['btnText'=>__('Edit'), 'Text'=>__('Edit service')])
        <div class="pt-4">
            <a class="btn btn-primary col-3" href="{{ route('service.show', $service) }}">{{__('Return')}}</a>
        </div>
    </form>
</div>

@endsection