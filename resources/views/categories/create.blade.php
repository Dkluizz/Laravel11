@extends('layouts.layoutAdm')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
        class='col-md-6 offset-md-3 mt-5 shadow-lg p-3 mb-5 bg-white rounded'>
        <div class="form-group mb-3">
            @csrf
            <label class=" mb-2" for="text">Tipo de Categoria</label>
            <input type="text" class="form-control" name="name" placeholder="Categoria" required id="name">
            <br />
            <label class=" mb-2" for="text">Descrição</label>
            <input type="text" class="form-control" name="description" placeholder="Descrição" required id="description">
            <br />
            <output>Insira uma imagem para a categoria</output>
            <output>Insira icones para as categorias que não possuam fundo para melhor visualização</output>
            <input type="file" class="form-control" name="icon" required id="icon">
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>

    <div class="container text-white">


        <div class="row justify-content-start">
            @foreach ($listCat as $cat)
                <div class="col-3 mb-4">


                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h4 class="text-black"><img src="{{ url($cat->icon) }}" class="img-fluid"
                                    style="width: 40px; height: 40px"> {{ $cat->name }}</h4>
                            <div class="text-center d-flex gap-2">
                                <form action="{{ route('categories.edit', ['category' => $cat]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary">Atualizar </button>
                                </form>

                                <form action="{{ route('categories.destroy', ['category' => $cat]) }}" method="POST">
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


    </div>
@endsection
