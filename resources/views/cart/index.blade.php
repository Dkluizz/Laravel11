@extends('layouts.layout')

@section('content')
    <div class="container-lg  "  style="margin-top: 7rem !important">
        <div class="row col justify-content-evenly">
            <div class="mb-3 mt-4 " style="max-width: 45rem;">

                @if (session('mensagem'))
                    <div class="alert alert-success">
                        <p>{{ session('mensagem') }}</p>
                    </div>
                @endif

                @foreach ($cartItems as $cartP)
                    <div class="card mb-2">
                        <div class="row">
                            <div class="col-md-3 col-sm-6  ">
                                <img src="{{ $cartP->photo }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cartP->name }}</h5>
                                    <div class="row justify-content-start">
                                        <div class="col-9">
                                            <h5 class="card-text">{{ $cartP->value }}</h5>
                                        </div>
                                        <div class="col-3">
                                           
                                          <form action="{{ route('cart.update', ['cart' => $cartP->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT') 
                                              <input type="number" class="form-control" min="1" name="quantity" value="{{ $cartP->quantity }}"
                                              onchange="this.form.submit()">
                                          </form>
                                        </div>
                                    </div>
                                <p class="card-text">{{ $cartP->description }}</p>


                                <form action="{{ route('cart.destroy', ['cart' => $cartP]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-primary">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>


        <div class="card  mt-4" style="width: 20rem; height: 100%;">
            <div class="card-body">
                <h5 class="card-title">Total : R${{ $total }}</h5>

                <form class="row g-3" action="{{ route('cart.clear') }}" method="post">
                    @csrf
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="adress">
                    </div>
                    <div class="col-md-8">
                        <label for="inputCity" class="form-label">Cidade</label>
                        <input type="text" class="form-control" name="city">
                    </div>
                    <div class="col-md-4">
                        <label for="inputZip" class="form-label">Estado</label>
                        <input type="text" class="form-control " name="estate">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">CEP</label>
                        <input type="text" class="form-control" name="zip">
                    </div>
                </form>
                <p class="card-text"></p>
                <form action="{{ route('cart.clear') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-primary"> Finalizar </button>
                </form>
                <a href="{{ route('home') }}" type="button" class="btn btn-outline-primary"> Voltar </button></a>
            </div>
        </div>


    </div>
    </div>
@endsection
