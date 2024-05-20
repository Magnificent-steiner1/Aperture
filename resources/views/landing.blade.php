<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperture</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
        font-family: 'Roboto', sans-serif;
    }

    .guest-components, .client-components, .photographer-components {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        background-image: url('/images/background/bg-home3.jpg');
        background-size: cover;
        background-position: center;
    }

    .text-content {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .footer {
        padding: 20px 0;
        background-color: #343a40;
        color: white;
        text-align: center;
    }
    </style>
</head>
<body>

@include('navbar')

@if(auth()->check())
	@if(auth()->user()->isPhotographer())
		@include('photographer-components')
	@else
        @include('client-components')
	@endif
@else
	@include('guest-components')
@endif

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 Aperture. All Rights Reserved.</p>
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
            </li>
        </ul>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 0) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

</body> 
</html>

