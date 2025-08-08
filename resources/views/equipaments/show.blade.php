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
            <p class="evets-owner">
                <ion-icon name="star-outline"></ion-icon>{{ $equipamentOwner['name'] }}
            </p>
            <div id="calendar" style="margin-bottom: 20px;"></div>

            <!-- Mensagens de sessão -->
            @if(session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-2">
                    {{ session('error') }}
                </div>
            @endif

            
            <form action="{{ route('equipaments.reserve') }}" method="POST" id="equipament-form">
                @csrf                
                <label for="data_range">Escolha o período para reserva:</label>
                <input type="text" id="data_range" name="data_range" class="form-control" required>                
                <input type="hidden" name="equipament_id" value="{{ $equipament->id }}">
                <p class="equipament-value">Valor da diária: R$ {{ $equipament->value }}</p>              
                <p id="total-value" class="equipament-value">Valor total: R$ 0,00</p>
                <button type="submit" class="btn btn-primary mt-2">Reservar</button>
                <a href="/" class="btn btn-secondary mt-2">Voltar</a>
            </form>
                <script>
                    const reservedDates = @json($reservedDates);
                    document.addEventListener('DOMContentLoaded', function () {
                        const diaria = {{ $equipament->value }};
                        const disabledDates = reservedDates.map(dateStr => new Date(dateStr + 'T00:00:00'));

                        flatpickr("#data_range", {
                            mode: "range",
                            dateFormat: "d/m/Y",
                            disable: disabledDates,
                            minDate: "today", 
                            onChange: function(selectedDates) {
                                if (selectedDates.length === 2) {
                                    const start = selectedDates[0];
                                    const end = selectedDates[1];

                                    const diffTime = Math.abs(end - start);
                                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                                    const total = diaria * diffDays;

                                    const formatter = new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    });

                                    document.getElementById('total-value').textContent = `Valor total: ${formatter.format(total)}`;
                                } else {
                                    document.getElementById('total-value').textContent = `Valor total: R$ 0,00`;
                                }
                            }
                        });
                    });
                </script>

        </div>

        <!-- Passando datas reservadas para o JS -->

       


    </div>
</div>

@endsection 