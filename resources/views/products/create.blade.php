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

    <div class="container text-white my-5 d-flex justify-content-around">
        <div class="row mx-2">
            <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" class=" col-md  ">
                @csrf
                <div class="mt-1">
                    <label for="name" class="form-label">Nome do Produto:</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome do Produto">

                    <div class="mt-2">
                        <label for="photo">Imagem do Produto</label>
                        <input type="file" class="form-control-file" name="photo">
                    </div>

                    <div class=" mt-2">
                        <label for="id_category" class="form-label">Escolha uma categoria</label>
                        <select class="form-select" name="id_category" aria-label="Default select example">
                            <option selected>Categorias</option>
                            @foreach ($list as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->id }}.{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" mt-2">
                        <label for="description" class="form-label">Descrição Básica</label>
                        <input type="text" class="form-control" placeholder="Descrição" name="description">
                    </div>
                </div>

                <div class="col-4 ">
                    <label for="value" class="form-label">Quantidade:</label>
                    <input type="number" class="form-control" name="quantity" required>
                </div>

                <div class="col-4 ">
                    <label for="value" class="form-label">Valor:</label>
                    <input type="text" name="value" class="form-control"  pattern="^\d+(\,\d{1,2})?$" placeholder="0,00" required onkeyup="formatCurrency(this)">
                </div>

                <div class="mt-2 py-2">
                    <button type="submit" class="btn btn-primary">Enviar</button>

                </div>

            </form>

            <div class="col-md m-5 ">
                <img src="{{ url('/assets/images/logo2.png') }}" class="mx-5 justify-center" alt="LuckyShopp">
            </div>

        </div>
    </div>

    <script>
      function formatCurrency(input) {
          let value = input.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico
          value = (value / 100).toFixed(2) + ''; // Divide por 100 e fixa 2 casas decimais
          value = value.replace(".", ","); // Substitui ponto por vírgula
          input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Formata milhares com ponto
      }
      </script>
@endsection
