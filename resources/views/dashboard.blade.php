@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Minha Dashboard</h1>

    <hr>

    <h2>Meus Equipamentos</h2>
    @if($equipaments->isEmpty())
        <p>Você ainda não cadastrou nenhum equipamento.</p>
    @else
        <ul class="list-group mb-4">
            @foreach($equipaments as $equipament)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $equipament->title }}
                    <a href="{{ route('equipaments.show', $equipament->id) }}" class="btn btn-sm btn-primary">Ver</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Minhas Reservas</h2>
    @if($orders->isEmpty())
        <p>Você ainda não realizou nenhuma reserva.</p>
    @else
        <ul class="list-group">
            @foreach($orders as $order)
                <li class="list-group-item">
                    Equipamento: {{ $order->equipament->title ?? 'Indisponível' }} <br>
                    Período: {{ $order->start_date }} a {{ $order->end_date }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
