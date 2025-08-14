@extends('layouts.main')

@section('title', 'Eloca')

@section('content')

<div id="equipament-create-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $equipament->title }}</h1>
    <form action="/equipaments/update/{{ $equipament->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="image">Imagem do equipamento:</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="/img/equipaments/{{ $equipament->image}}" alt="{{ $equipament->title }}" class="img-preview">
        </div>
        <div class="form-group">
            <label for="title">Equipamento:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Nome do equipamento" value="{{ $equipament->title }}">
        </div>
        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no equipamento?">{{ $equipament->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="value">Valor:</label>
            <input type="text" class="form-control" id="value" name="value" placeholder="Local do equipamento" value="{{ $equipament->value }}">
        </div>
        <div class="form-group">
            <label for="private">O equipamneto está disponível?:</label>
            <select name="private" id="private" class="form-control">
                <option value="0">Sim</option>
                <option value="1" {{ $equipament->private == 1 ? "selected='selected'" : ""}}>Não</option>
            </select>
        </div>
        <label for="title">Editar equipamento:</label>
        <input type="submit" class="btn btn-primary" value="Editar equipamento" placeholder="Editar equipamento">
    </form>
        
</div>

@endsection