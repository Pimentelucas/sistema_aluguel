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
                        </ul>
                    </div>
                </nav>
            </header>
            <main>
                @yield('content')
            </main>
        
            <footer>
                <p>Eloca &copy; 2016</p>
            </footer>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        </body>
</html>
