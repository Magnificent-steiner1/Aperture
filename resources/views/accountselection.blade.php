<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Selection</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand img {
            max-height: 40px;
            /* Set maximum height for the logo */
        }

        .account-box {
            border: 1px solid #ced4da;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .account-box:hover {
            background-color: #f8f9fa;
        }

        .account-box.selected {
            background-color: #28a745; /* Changed to green */
            color: white;
        }

        .login-link {
            font-weight: bold;
            color: #007bff;
            cursor: pointer;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{{ asset('/images/logo/logo-main2.png') }}" alt="Aperture"></a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Select Your Account Type</h2>
                        <div class="account-box" id="clientBox">
                            <input class="form-check-input d-none" type="checkbox" name="account_type" id="client" value="client">
                            <label class="form-check-label" for="client">
                                <i class="bi bi-person"></i> I'm a client, hiring a photographer
                            </label>
                        </div>
                        <div class="account-box" id="photographerBox">
                            <input class="form-check-input d-none" type="checkbox" name="account_type" id="photographer" value="photographer">
                            <label class="form-check-label" for="photographer">
                                <i class="bi bi-camera"></i> I'm a photographer, looking for clients
                            </label>
                        </div>
                        <div class="text-center"> <!-- Centering the button -->
                            <button id="createAccountBtn" class="btn btn-primary mt-4" disabled>Create Account</button>
                        </div>
                        <div class="mt-3 text-center">
                            Already have an account? <a href="login.blade.php" class="login-link">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.account-box').click(function() {
                $('.account-box').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="checkbox"]').prop('checked', true);
                $('#createAccountBtn').prop('disabled', false);
            });

            $('#createAccountBtn').click(function() {
    var accountType = $("input[name='account_type']:checked").val();
    window.location.href = "/register/" + accountType;
});

        });
    </script>
</body>

</html>
