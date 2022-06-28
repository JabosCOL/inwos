<div class="pr-4 d-flex justify-content-end">
  <a class="btn btn-primary" href="{{ route('service.create') }}">{{ __('Create service') }}</a>
</div>
<div class="row p-4">

  <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4">
    <div class="list-group col-md-12 pb-5 pr-0">
      <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
        {{ __('Categories') }}
      </a>
      @foreach ($categories as $id => $name)
      <a href="{{ route('category.index', $id) }}" value="{{ $id }}" class="list-group-item list-group-item-action">{{ $name }}</a>
      @endforeach
    </div>
    <div class="list-group col-md-12 p-0 mb-4">
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

            @if ($filter)
            <p>Filtros: {{ $filter->name }}</p>
            <cite title="Source Title"><a href="{{ route('home') }}">Quitar filtros</a></cite>
            @endif

          </figure>
        </div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="row">
            @foreach ($services as $service)
            <div class="service card mb-3 pl-0">
              <div class="row g-0">
                <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3 col-xxl-2">
                  <img src="/storage/{{ $service->image }}" class="img-fluid rounded-start" alt="{{ $service->name }}" style="width: 100%; height: 100%;">
                </div>
                <div class="col-sm-6 col-md-7 col-lg-8 col-xl-9 col-xxl-10">
                  <div class="card-body">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <small class="card-text">{{ $service->city->name }}</small>
                    <p class="card-text">{{ $service->description }}</p>
                    <p class="card-text"><small class="text-muted">${{ number_format($service->price) }}</small></p>
                    <p class="card-text"><small class="text-muted">{{ $service->created_at }}</small></p>

                    <a href="{{ route('service.show', $service) }}" class="btn btn-primary">{{ __('See service') }}</a>

                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="d-flex align-items-center justify-content-center">
            {{ $services->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
