@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Reset password') }}</div>
        <div class="card-body">

          <form method="POST" action="{{ route('resetPassword') }}">
            @csrf

            <div class="form-group">
              <label for="current_password" class="col-md-4 control-label">{{ __('Current password') }}</label>

              <div class="col-md-6">
                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">

                @error('current_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="new_password" class="col-md-4 control-label">{{ __('New password') }}</label>

              <div class="col-md-6">
                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">

                @error('new_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="new_password_confirmation" class="col-md-4 control-label">{{ __('Confirm new password') }}</label>

              <div class="col-md-6">
                <input id="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation">

                @error('new_password_confirmation')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Reset password') }}
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
