<div class="container">
  <div class="row justify-content-center pt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">{{ __('Services') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="row">
            <div class="service card mb-3 col-md-12 col-lg-12 pl-0">
              <div class="row g-0">
                <div class="col-sm-6 col-md-3 col-lg-2">
                  <img src="/storage/{{ $service->image }}" class="img-fluid rounded-start" alt="{{ $service->name }}" style="background-size: cover;">
                </div>
                <div class="col-sm-6 col-md-9 col-lg-10">
                  <div class="card-body">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <small class="card-text">{{ $service->city->name }}</small>
                    <p class="card-text">{{ $service->description }}</p>
                    <p class="card-text"><small class="text-muted">${{ $service->price }}</small></p>
                    <p class="card-text"><small class="text-muted">{{ $service->created_at->diffForHumans() }}</small></p>

                  </div>
                </div>
              </div>
            </div>
            @if (Auth::user()->id == $user_id)
            <div class="btn-group">
              <a href="{{ route('service.edit', $service) }}" class="col-md-2 btn btn-primary text-white">{{__('Edit')}}</a>
              <div class="pl-3">
                <form action="{{ route('service.destroy', $service) }}" method="post" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger text-white" onclick="return confirm('Deseas borrar tu servicio?')">{{__('Delete')}}</button>
                </form>
              </div>
            </div>
            @endif
            @if (Auth::user()->id != $user_id)
            <form action="{{ route('order.create')}}" method="post" class="d-inline">
              @csrf
              <button class="btn btn-danger text-white" onclick="return confirm('Deseas ordenar este servicio?')">{{__('Order!')}}</button>
            </form>

            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="pt-4">
      <a class="btn btn-primary col-3" href="{{ route($route) }}">{{__('Return')}}</a>
    </div>
  </div>
</div>
</div>
