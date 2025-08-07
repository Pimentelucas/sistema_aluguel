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
            <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var calendarEl = document.getElementById('calendar');
                        var equipamentId = {{ $equipament->id }};

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            locale: 'pt-br',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek'
                            },
                            events: `/equipaments/${equipamentId}/reservations`,
                            selectable: true,
                            select: function (info) {
                                $('#start_date').val(moment(info.start).format('DD/MM/YYYY'));
                                $('#end_date').val(moment(info.end).subtract(1, 'days').format('DD/MM/YYYY'));
                                $('#reservationModal').modal('show');
                            }
                        });

                        calendar.render();
                    });
            </script>

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

            <!-- ✅ Formulário de reserva -->
            <form action="{{ route('equipaments.reserve') }}" method="POST" id="equipament-form">
                @csrf

                <!-- Calendário com intervalo de datas -->
                <label for="data_range">Escolha o período para reserva:</label>
                <input type="text" id="data_range" name="data_range" class="form-control" required>

                <!-- ID do equipamento (oculto) -->
                <input type="hidden" name="equipament_id" value="{{ $equipament->id }}">

                <!-- Valor da diária exibido -->
                <p class="equipament-value">Valor da diária: R$ {{ $equipament->value }}</p>

                <!-- Valor total (exibido após seleção de datas) -->
                <p id="total-value" class="equipament-value">Valor total: R$ 0,00</p>


                <!-- Botões -->
                <button type="submit" class="btn btn-primary mt-2">Reservar</button>
                <a href="/" class="btn btn-secondary mt-2">Voltar</a>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const reservedDates = @json($reservedDates);
                    const diaria = {{ $equipament->value }};

                    flatpickr("#data_range", {
                        mode: "range",
                        dateFormat: "d/m/Y",
                        disable: reservedDates,
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
        @if(isset($reservedDates))
            <script>
                const reservedDates = @json($reservedDates);
            </script>
        @endif

    </div>
</div>

@endsection 