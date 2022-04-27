@extends('layouts.app')

@section('content')
@if (auth()->user()->role == 'Proveedor')
<div class="pr-5 d-flex justify-content-end">
    <a class="btn btn-primary" href="{{ route('service.create') }}">{{ __('Create service') }}</a>
</div>
@endif
    <div class="row p-4">
       
        <div class="row col-xl-2 col-lg-3 col-md-3 col-sm-4">
            <div class="list-group col-md-12">
                <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                    {{ __('Categories') }}
                </a>
                @foreach ($categories as $id => $name)
                <a href="{{ route('category.index', $id) }}" value="{{ $id }}" class="list-group-item list-group-item-action">{{ $name }}</a>
                @endforeach
            </div>
            <div class="list-group col-md-12  pt-0">
                <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                    {{ __('Cities') }}
                </a>
                @foreach ($cities as $id => $name)
                <a href="{{ route('city.index', $id) }}" value="{{ $id }}" class="list-group-item list-group-item-action">{{ $name }}</a>
                @endforeach
            </div>
        </div>
        
        
        <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 pl-0 pr-0">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <figure class="text-start">
                            <blockquote class="blockquote">
                              <p>{{ __('Services') }}</p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                @if ($filter)
                                <p>Filtros: <u>{{ $filter->name }}</u></p>
                                <cite title="Source Title"><a href="{{ route('home') }}">Quitar filtros</a></cite>
                               @endif 
                            </figcaption>
                          </figure>
                        </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
                            @foreach ($services as $service)
                            <div class="card mb-3">
                                <div class="row g-0">
                                  <div class="col-md-2">
                                    <img src="/storage/{{ $service->image }}" class="img-fluid rounded-start" alt="{{ $service->name }}" style="height:210px; width:250px; object-fit: cover">
                                  </div>
                                  <div class="col-md-10">
                                    <div class="card-body">
                                      <h5 class="card-title">{{ $service->name }}</h5>
                                      <small class="card-text">{{ $service->city->name }}</small>
                                      <p class="card-text">{{ $service->description }}</p>
                                      <p class="card-text"><small class="text-muted">{{ $service->created_at->diffForHumans() }}</small></p>
                                      <div class="d-flex justify-content-end">
                                        <a href="{{ route('service.show', $service) }}"
                                            class="btn btn-primary">{{ __('See service') }}</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
