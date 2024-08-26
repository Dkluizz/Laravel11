@extends('layouts.layout')

@section('content')
    <div class="container-fluid " style="margin-top: 7rem !important">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-ride="carousel" >
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="{{ url('/assets/images/bannerCarousel1.png') }}" class="d-block w-100 h-80" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="{{ url('/assets/images/bannerCarousel.png') }}" class="d-block w-100 h-80" alt="...">
                </div>

            </div>
        </div>
        <h3 class="text-center text-white mt-2">So na LuckyShopp, você encontra tudo para qualquer Setup ou Desafio.</h3>
    </div>
    <br />

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

    <div class=" row row-cols-3 row-cols-md-6  justify-content-evenly ">
        
        @foreach ($listProduct as $prod)
            <div class="card mx-2 col-md-2 col-sm-3 col-10 mb-3">
                <img src="{{ url($prod->photo) }}" class="card-img-top rounded" alt="..."
                    style="width: 100%; height: 100% ">
                <div class="card-body opacity-75">
                    <h5 class="card-title">{{ $prod->name }}</h5>
                    <p class="card-text">R$ {{ $prod->value }}</p>
                    <div class="text-center d-flex gap-4">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">Comprar </button>
                            @auth
                                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            @endauth
                            <input type="hidden" name="product_id" value="{{ $prod->id }}">
                            <input type="hidden" name="name" value="{{ $prod->name }}">
                            <input type="hidden" name="photo" value="{{ $prod->photo }}">
                            <input type="hidden" name="value" value="{{ $prod->value }}">
                            <input type="hidden" name="description" value="{{ $prod->description }}">
                        </form>
                        <a href="{{ route('products.show', ['product' => $prod->id]) }}"> <button type="submit"
                                class="btn btn-outline-primary">Detalhes </button></a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    
@endsection
