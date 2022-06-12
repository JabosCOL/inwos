@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ route('survey.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card text-center">
      <div class="card-header">
        <h4>{{__('Satisfaction survey')}}</h4>
      </div>
      <div class="card-body row g-3">
        <div class="form-group">
          <input id="service_id" class="form-control" type="number" name="service_id" hidden value="{{$service_id}}">
        </div>
        <div class="col-md-6">
          <label for="serviceQualification" class="form-label">{{__('Service qualification')}}</label>
          <select class="form-select border-2 @error('serviceQualification') is-invalid @enderror" id="serviceQualification" name="serviceQualification">
            <option value="">{{ __('Choose from 1 to 5') }}</option>
            @for ($i = 1; $i <=5; $i++)
              <option value="{{ $i }}" {{ $i == old('serviceQualification') ? "selected" : '' }}>{{ $i }}</option>
              @endfor
          </select>
          @error('serviceQualification')
          <span class="invalid-feedback">
            <strong>{{$message}}</strong>
          </span>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="filingQualification" class="form-label">{{__('Filing qualification')}}</label>
          <select class="form-select border-2 @error('filingQualification') is-invalid @enderror" id="filingQualification" name="filingQualification">
            <option value="">{{ __('Choose from 1 to 5') }}</option>
            @for ($i = 1; $i <=5; $i++)
             <option value="{{ $i }}" {{ $i == old('filingQualification') ? "selected" : '' }}>{{ $i }}</option>
              @endfor
          </select>
          @error('filingQualification')
          <span class="invalid-feedback">
            <strong>{{$message}}</strong>
          </span>
          @enderror
        </div>
        <div class="col-md-12">
          <label for="comment" class="form-label">{{__('Comments')}}</label>
          <textarea rows="5" name="comment" type="text" class="form-control border-2 @error('comment') is-invalid @enderror" id="comment" placeholder="{{ __('Insert a comment') }}">{{ old('comment') }}</textarea>
          @error('comment')
          <span class="invalid-feedback">
            <strong>{{$message}}</strong>
          </span>
          @enderror
        </div>
      </div>
      <div class="card-footer text-muted pb-3 pt-3">
        <button class="btn btn-primary col-8" type="submit">{{ __('Send') }}</button>
      </div>
  </form>
</div>

@endsection
