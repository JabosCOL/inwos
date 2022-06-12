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
                  <img src="/storage/{{ $service->image }}" class="img-fluid rounded-start" alt="{{ $service->name }}" style="width: 100%; height: 100%;">
                </div>
                <div class="col-sm-6 col-md-9 col-lg-10">
                  <div class="card-body">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <small class="card-text">{{ $service->city->name }}</small>
                    <p class="card-text">{{ $service->description }}</p>
                    <p class="card-text"><small class="text-muted">${{ $service->price }}</small></p>
                    <p class="card-text"><small class="text-muted">{{ $service->created_at }}</small></p>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer p-4 d-flex justify-content-between">
          <div>
            <a class="btn btn-primary" href="{{ route($route) }}">{{__('Return')}}</a>
          </div>
          <div class="d-flex justify-content-end">
            @if (Auth::user()->id == $user_id)
            <a href="{{ route('service.edit', $service) }}" class="btn btn-primary text-white">{{__('Edit')}}</a>
            <div class="pl-3">
              <form action="{{ route('service.destroy', $service) }}" method="post" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger text-white" onclick="return confirm('Deseas borrar tu servicio?')">{{__('Delete')}}</button>
              </form>
            </div>
            @endif
          </div>
          @if (Auth::user()->id != $user_id)

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
            {{__('Schedule service')}}
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{__('Schedule service')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('order.create', $service)}}" method="post" class="d-inline">
                    <p>{{__('Select date and time')}}</p>
                    @csrf
                    <input type="number" name="service_id" value="{{ $service->id }}" hidden>
                    <div style="float:left;">
                      <input type="date" name="date" id="date" style="width:150px;float:left;" class="form-control @error('date') is-invalid @enderror" required>
                      @error('date')
                      <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                      </span>
                      @enderror
                      <input id="timepkr" name="time" style="width:100px;float:left;" class="form-control ml-2 @error('time') is-invalid @enderror" placeholder="HH:MM" required />
                      <button type="button" class="btn btn-primary" onclick="showpickers('timepkr',12)" style="width:40px;float:left;"><i class="fa fa-clock-o"></i>
                        @error('time')
                        <span class="invalid-feedback">
                          <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="timepicker"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" onclick="return confirm('Deseas ordenar este servicio?')">{{__('Order!')}}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
</div>
