@extends('layouts.layoutAdm')

@section('content')
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

    <form action="{{ route('categories.update', ['category' => $cat]) }}" method="POST" enctype="multipart/form-data"
        class='col-md-6 offset-md-3 mt-5 shadow-lg p-3 mb-5 bg-white rounded'>
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
           
            <label class=" mb-2" for="text">Tipo de Categoria</label>
            <input type="text" class="form-control" name="name" placeholder="Categoria" required id="name"
                value="{{ $cat->name }}">
            <br />
            <label class=" mb-2" for="text">Descrição</label>
            <input type="text" class="form-control" name="description" placeholder="Descrição" required
                value="{{ $cat->description }}" id="description">
            <br />
            <output>Insira uma imagem para a categoria</output>
            <output>Insira icones para as categorias que não possuam fundo para melhor visualização</output>
            <input type="file" class="form-control" name="icon" id="icon">
            <img class="rounded" src="{{ $cat->icon }}" alt="{{ $cat->name }}" style="width: 15%; height: 15%">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>

   

@endsection
