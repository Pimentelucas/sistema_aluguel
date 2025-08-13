@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Equipamentos</h1>
</div>

<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(isset($createdEquipaments) && $createdEquipaments->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($createdEquipaments as $equipament)
                <tr>
                    <td scropt="row">{{ $loop->index + 1 }}</td>
                    <td>
                        <a href="/equipaments/{{ $equipament->id }}" class="event-title-link">
                            {{ $equipament->title ?? $equipament->name }}
                        </a>
                    </td>
                    <td>
                        <a href="/equipaments/edit/{{ $equipament->id }}" class="btn btn-info edit-btn">
                            <ion-icon name="create-outline"></ion-icon> Editar
                        </a>

                        <form action="/equipaments/{{ $equipament->id }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn" onclick="return confirm('Confirma exclusão?')">
                                <ion-icon name="trash-outline"></ion-icon> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach    
        </tbody>
    </table>
    @else
    <p>Você ainda não tem equipamentos, <a href="/equipaments/create">cadastrar equipamento</a></p>
    @endif
</div>

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Equipamentos que aluguei</h1>
</div>

<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(isset($rentedEquipaments) && $rentedEquipaments->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentedEquipaments as $equipament)
                <tr>
                    <td scropt="row">{{ $loop->index + 1 }}</td>
                    <td>
                        <a href="/equipaments/{{ $equipament->id }}" class="event-title-link">
                            {{ $equipament->title ?? $equipament->name }}
                        </a>
                    </td>
                    <td>
                        <a href="/equipaments/{{ $equipament->id }}" class="btn btn-secondary btn-sm">Ver</a>
                    </td>
                </tr>
            @endforeach    
        </tbody>
    </table>
    @else
    <p>Você ainda não alugou nenhum equipamento.</p>
    @endif
</div>
@endsection
