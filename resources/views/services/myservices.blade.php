@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Services') }}</div>

                <div class="card-body">
                    <div class="row">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>

                        @endif
                        @forelse ($services as $service)
                        <div class="service card mb-3 pl-0">
                            <div class="row g-0">
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <img src="/storage/{{ $service->image }}" class="img-fluid rounded-start" alt="{{ $service->name }}" style="width: 100%; height: 100%">
                                </div>
                                <div class="col-sm-6 col-md-8 col-lg-9 col-xl-10">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->name }}</h5>
                                        <small class="card-text">{{ $service->city->name }}</small>
                                        <p class="card-text">{{ $service->description }}</p>
                                        <p class="card-text"><small class="text-muted">${{ number_format($service->price) }}</small></p>
                                        <p class="card-text"><small class="text-muted">{{ $service->created_at }}</small></p>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('userServices.show', $service) }}" class="btn btn-primary">{{ __('See service') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div>
                            <p>Aun no tienes servicios</p>
                            <a class="btn btn-primary" href="{{ route('service.create') }}">{{__('Create your first service')}}</a>
                        </div>
                        @endforelse

                    </div>

                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $services->links() }}
                </div>

            </div>
            <div class="pt-4">
                <a class="btn btn-primary col-3" href="{{ route('home') }}">{{__('Return')}}</a>
            </div>
        </div>
    </div>
    @endsection
