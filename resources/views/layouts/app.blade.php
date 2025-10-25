<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('title', config('app.name'))</title>
</head>

<body class="container">
    <h1 class="mt-3">@yield('title')</h1>
    @if (session()->has('success'))
        <div id="success-alert" class="alert alert-success mt-3 mb-10" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const successAlert = document.getElementById('success-alert');
                if (successAlert) {
                    successAlert.style.transition = 'opacity 1s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 1000);
                }
            }, 3000);
        });
    </script>
    @yield('scripts')
</body>

</html>
