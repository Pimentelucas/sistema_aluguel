@extends('layouts.main')

@section('title', $equipament->title)

@section('content')
    <div id="equipament-show-container" class="col-md-10 offset-md-1">
        <div class="row">
            <div id="equipament-image-container" class="col-md-6">
                <img src="/img/equipaments/{{ $equipament->image }}" alt="{{ $equipament->title }}" class="img-fluid">
                <div id="description-container">
                    <h3>Sobre o equipamento:</h3>
                    <p class="equipament-description">{{ $equipament->description }}</p>
                </div>
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $equipament->title }}</h1>
                <p class="evets-owner"><ion-icon name="star-outline"></ion-icon>{{ $equipamentOwner['name'] }}</p>

                @if($equipament->private)
                    <p class="equipament-private">Este é um equipamento privado.</p>
                @else
                    <p class="equipament-public">Este equipamento é aberto ao público.</p>
                @endif
                @if (!$hasUserJoined)
                    <form action="/equipaments/join/{{ $equipament->id }}" method="POST" id="equipament-form">
                        @csrf
                        <a href="/equipaments/join/{{ $equipament->id }}" class="btn btn-primary" id="equipament-submit" onclick="equipament.prequipamentDefault(); this.closest('form').submit();">Confirmar presença</a>
                        <a href="/" class="btn btn-secondary">Voltar</a>
                    </form> 
                @else
                    <p class="already-joined-msg">Você já está participando deste equipamento!</p>
                @endif 
            </div>
        </div>
    </div>
@endsection 