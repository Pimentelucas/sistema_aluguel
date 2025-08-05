<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        
        <link href="https://fonts.googleapis.com/css2?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

        <link rel="stylesheet" href="/css/styles.css">
        <script src="/js/scripts.js"></script>
    </head>
    <body>
        <div class="content-wrapper">
            <header>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="collapse navbar-collapse" id="navbar">
                        <a href="/" class="navbar-brand">
                            <img src="/img/logo.png" alt="Eloca">
                        </a>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Equipamentos</a>
                            </li>
                            <li class="nav-item">
                                <a href="/equipaments/create" class="nav-link">Cadastar Equipamentos</a>
                            </li>
                            @auth
                                <li class="nav-item">
                                    <a href="/dashboard" class="nav-link">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <a href="/logout"
                                            class="nav-link"
                                            onclick="event.preventDefault(); this.closest('form').submit();">Sair
                                        </a>
                                    </form>
                                </li>
                            @endauth
                            @guest
                                <li class="nav-item">
                                    <a href="/login" class="nav-link">Entrar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/register" class="nav-link">Cadastrar</a>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </header>
            <main>
                <div class="container-fluid">
                    <div class="row">
                        @if (@session('msg'))
                            <p class="msg">{{ session('msg') }}</p>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </main>      
            <footer>
                <p>Eloca &copy; 2016</p>
            </footer>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        </body>
</html>
