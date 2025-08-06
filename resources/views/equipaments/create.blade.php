@extends('layouts.main')

@section('title', 'Eloca')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie o seu evento</h1>
    <form action="/equipaments" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Imagem do equipamento:</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="title">Nome:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Nome do equipamento">
        </div>
        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control" placeholder="O que seu equipamento faz?"></textarea>
        </div>
        <div class="form-group">
            <label for="value">Valor da diária:</label>
            <input type="text" class="form-control" id="value" name="value" placeholder="Diária do equipamento">
        </div>
        <div class="form-group">
            <label for="private">O equipamneto está disponível?:</label>
            <select name="private" id="private" class="form-control">
                <option value="0">Sim</option>
                <option value="1">Não</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Cadastrar Equipamento">
        <a href="/" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection 