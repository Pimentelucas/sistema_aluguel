@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus equipamentos</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-equipaments-container">
    @if(count($equipaments) > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipaments as $equipament)
                <tr>
                    <td scropt="row">{{ $loop->index + 1 }}</td>
                    <td><a href="/equipaments/{{ $equipament->id }}" class="equipament-title-link">{{ $equipament->title }}</a></td>
                    <td>    
                        <a href="/equipaments/edit/{{ $equipament->id}}" class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon> Editar</a> 
                        <form action="/equipaments/{{ $equipament->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon>Deletar</button>
                        </form>
                </tr>
            @endforeach    
        </tbody>
    </table>
    @else
    <p>Você ainda não tem equipamentos, <a href="/equipaments/create">criar equipamento</a></p>
    @endif
</div>
<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>equipamentos que estou participando</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-equipaments-container">
    @if(count($equipamentsasparticipant) > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipamentsasparticipant as $equipament)
                <tr>
                    <td scropt="row">{{ $loop->index + 1 }}</td>
                    <td><a href="/equipaments/{{ $equipament->id }}" class="equipament-title-link">{{ $equipament->title }}</a></td>
                    <td>{{ count($equipament->users) }}</td>
                    <td>
                        <form action="/equipaments/leave/{{ $equipament->id }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon>Sair do equipamento</button>
                        </form>
                    </td>
                </tr>
            @endforeach    
        </tbody>
    </table>
    @else
    <p>Você ainda não está participando de nenhum equipamento, <a href="/">veja todos os equipamentos</a></p>
    @endif
</div>
@endsection