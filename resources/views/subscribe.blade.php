@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #1ac28d">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>Subscribe to our awesome site</h1>
      </div>
    </div>

  </div>
</header>
@stop

@section('content')


@php 
$subscription = auth()->user()->subscriptions->first();
@endphp 

<section class="section" id="section-vtab">
    @if(!$subscription)
    <div class="container text-center">
   
    <vue-stripe email="{{ auth()->user()->email }}"></vue-stripe>

    </div>
    @else
    <div class="container text-center">
    <h2>Your current plan: </h2>                 
    <span class="badge badge-success" style="font-size:15px">{{ $subscription->name }}</span>
    </div>                  
    @endif


</section>    

@endsection


@section('scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection