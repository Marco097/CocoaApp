@extends('adminlte::page')

@section('title', 'Toppings')

@section('content_header')
    <h1>Carrito</h1>
@stop

@section('content')
    <div id = "app">
      <cart-component></cart-component>
    </div>
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
    @vite ('resources/css/app.css')
@stop

@section('js')
   <!-- <script> console.log('Hi!'); </script>-->
   @vite ('resources/js/app.js')
@stop