
@extends('layouts.layout')

@section('content')

<div>
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <div class="container mt-2 mb-3 ">
    <h3 class="text-center text-white">So na LuckyShopp, você encontra tudo que deseja.</h3>
    <div class="row justify-content-evenly mt-4">
  
  <img src="{{($show->photo)}}" class="img col-5 shadow-lg p-2 bg-light rounded">
  <div class="form-group col-6">
    <h4 class="text-white" >
      <p>{{($show->name)}}</p>
      <p>Valor: {{($show->value)}}</p>
      <p>{{($show->description)}}</p>
      <p>Quantidade: {{($show->quantity)}}</p>
    </h4>
    
    <form action="{{route('cart.store')}}" method="POST">
        @csrf
        <input type="number" name="quantity" min="1"  max="{{$show->quantity}}" class="form-control" style="width: 7rem" placeholder="Qtde: 1">
        <br/>
       <button type="submit" class="btn btn-primary">Comprar </button>
        @auth
          <input type="hidden" name="id_user"  value="{{Auth::user()->id}}">
        @endauth
        <input type="hidden" name="product_id" value="{{$show->id}}">
        <input type="hidden" name="name" value="{{$show->name}}">
        <input type="hidden" name="photo" value="{{$show->photo}}">
        <input type="hidden" name="value" value="{{$show->value}}">
        <input type="hidden" name="description" value="{{$show->description}}">
    </form>
    
  </div>
  </div>
  </div>

@endsection
