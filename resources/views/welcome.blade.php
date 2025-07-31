@extends('layouts.main')

@section('title', 'Eloca')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque um Equipamento</h1>
    <form action="/" method="GET">
        <input type="text" id="serach" name="search" class="form-control" placeholder="Procurar...">
    </form>
    <img src="/img/banner.jpg" alt="Eloca">
</div>

@endsection