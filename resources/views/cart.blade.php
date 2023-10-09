@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Carro') }}</div>

                <div id="app">
                    <cart-component></cart-component>
                   </div>
            </div>
        </div>
    </div>
</div>
@endsection
