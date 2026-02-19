@extends('layouts.sneat')

@section('title', 'Home')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">{{ __('Dashboard') }}</h5>
      </div>
      <div class="card-body">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif

        <p class="mb-0">{{ __('You are logged in!') }}</p>
      </div>
    </div>
  </div>
</div>
@endsection
