@extends('layouts.app')
@section('content')
<div class="container pt-3">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <div class="card text-center">
    <div class="card-header">
      <h4>{{__('Profile')}}</h4>
    </div>
    <div class="card-body">
      <div class="service card mb-3 pl-0">
        <div class="row g-0">
          <div class="col-sm-12 col-md-5 col-lg-4 col-xl-5 col-xxl-5">
            @if(Auth::user()->image)
            <img src="/storage/{{ $user->image }}" class="rounded-circle border mt-2" alt="{{ $user->name }}" style="width:50%;">
            @else
            <img src="/storage/images/users/default.png" class="rounded-circle border mt-2" alt="default" style="width:50%;">
            @endif
            <div class="form-group p-3">
              <label for="_userAvatarFile" class="btn btn-primary col-sm-6 col-md-4 mt-2">{{__('Update photo')}}</label>
              <input type="file" name="image" id="_userAvatarFile" hidden>
              <form action="{{ route('user.deleteImage', $user) }}" method="post" class="d-inline">
                @csrf @method('PATCH')
                <button class="btn btn-danger text-white col-sm-6 col-md-4" onclick="return confirm('Estas seguro de borrar tu foto?')">{{__('Delete photo')}}</button>
              </form>
            </div>
          </div>

          <div class="col-sm-12 col-md-7 col-lg-8 col-xl-7 col-xxl-7 d-flex align-items-center">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">{{__('Name')}}</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ $user->name }}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">{{__('Email')}}</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ $user->email }}
                </div>
              </div>
              <hr>
              <div class="pt-4">
                <a class="btn btn-primary col-7" href="{{ route('user.resetPassword') }}">{{ __('Reset Password') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="card text-center mt-5">
    <div class="card-header">
      <h4>{{__('Delete user') }}</h4>
    </div>
    <div class="card-body">
      <p>{{__('Once you delete a user, there is no going back. Please be certain.')}}</p>
    </div>

    <div class="card-footer text-muted pb-3 pt-3">
      <form action="{{ route('user.destroy', $user) }}" method="post" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger text-white col-8" onclick="return confirm('Estas seguro de borrar tu usuario?')">{{__('Delete')}}</button>
      </form>
    </div>
  </div>

  <div class="pt-4">
    <a class="btn btn-primary col-3" href="{{ route('home') }}">{{ __('Return') }}</a>
  </div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="ijaboCropTool-master/ijaboCropTool.min.js"></script>
<script>
  $('#_userAvatarFile').ijaboCropTool({
    allowedExtensions: ['jpg', 'jpeg', 'png'],
    buttonsText: ['ACCEPT', 'QUIT'],
    buttonsColor: ['#30bf7d', '#ee5155', -15],
    processUrl: '{{ route("user.updateImage") }}',
    withCSRF: ['_token', '{{ csrf_token() }}'],
    onSuccess: function(message, element, status) {
      alert(message);
    },
    onError: function(message, element, status) {
      alert(message);
    }
  });
</script>
@endsection
