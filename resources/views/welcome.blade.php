@extends('layouts.main')

@section('title', 'Eloca')

@section('content')

<div id="search-container" class="col-md-12">
    <form action="/" method="GET">
        <input type="text" id="serach" name="search" class="form-control" placeholder="Procurar...">
    </form>
</div>
<div id="equipaments-container" class="col-md-12">
    @if($search)
    <h2>Buscando por: {{ $search }}</h2>
    @else
    <h2>Nossos equipamentos</h2>
    @endif
        <div id="cards-container" class="row">
           @foreach ($equipaments as $equipament)
                @if(!$equipament->private)
                    <div class="card col-md-3">
                        <img src="/img/equipaments/{{ $equipament->image }}" alt="{{ $equipament->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $equipament->title }}</h5>
                            <a href="/equipaments/{{ $equipament->id }}" class="btn btn-primary">Saber mais</a>
                        </div>
                    </div>
                @endif
            @endforeach
            @if(count($equipaments)==0 && $search)
                <p>Não foi possível encontrar nenhum equipamento com {{ $search }}! <a href="/">Ver todos</a></p>
            @elseif(count($equipaments) == 0)
                <p>Não há equipamentos disponíveis</p>
            @endif
        </div>

</div>

@endsection