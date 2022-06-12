@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center pt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">{{ __('My surveys') }}</div>
        <div class="card-body">
          <div class="row">
            @forelse ($surveys as $survey)
            <div class="service card mb-3 pl-0">
              <div class="row g-0">
                <div class="col-sm-6 col-md-8 col-lg-9 col-xl-10">
                  <div class="card-body">
                    <h5 class="bold pb-2">{{ $survey->service->name }}</h5>
                    <p class="text-muted"><strong>{{__('Service qualification')}}:</strong> {{ $survey->service_qualification }}</p>
                    <p class="text-muted"><strong>{{__('Filing qualification')}}:</strong> {{ $survey->filing_qualification }}</p>
                    <p class="text-muted"><strong>{{__('Comments')}}:</strong> {{ $survey->comments }}</p>
                  </div>
                </div>
              </div>
            </div>
            @empty
            <div>
              <p>Aun no tienes calificaciones</p>
            </div>
            @endforelse
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          {{ $surveys->links() }}
        </div>
      </div>
      <div class="pt-4">
        <a class="btn btn-primary col-3" href="{{ route('home') }}">{{__('Return')}}</a>
      </div>
    </div>
  </div>
  @endsection
