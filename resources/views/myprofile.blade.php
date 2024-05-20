<!doctype html>
<html lang="en">

<head>
    <title>My Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            padding-top: 56px;
        }

        .profile-header {
            text-align: center;
            padding: 2rem 0;
            background-color: #9BB8CD;
            color: white;
            margin-bottom: 2rem;
        }

        .display-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-info {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-info h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            font-size: 1rem;
            color: #6c757d;
        }

        .edit-btn {
            color: #66d37e;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .edit-btn:hover {
            color: #083836;
        }

        .update-photo-btn {
            background-color: #66d37e;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .update-photo-btn:hover {
            background-color: #083836;
        }
    </style>
</head>

<body>
    <!-- Profile Header -->
    @include('navbar')
    <div class="profile-header">
        <img src="{{ $profilePhoto ? asset('storage/' . $profilePhoto) : 'https://via.placeholder.com/150' }}" alt="Profile Photo" class="display-photo">
        <h1>{{ $user->name }}</h1>
        <p>{{ ucfirst($user->account_type) }}</p>
        <button class="update-photo-btn" onclick="document.getElementById('profilePhotoInput').click()">Update Profile Photo</button>
        <form id="profilePhotoForm" action="{{ route('update.profile.photo') }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="file" id="profilePhotoInput" name="profile_photo" onchange="document.getElementById('profilePhotoForm').submit()">
        </form>
    </div>

    <!-- Profile Information -->
    <div class="container">
        <div class="profile-info">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Email:</strong></div>
                <div class="col-md-8 d-flex justify-content-between">
                    <span>{{ $user->email }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Date of Birth:</strong></div>
                <div class="col-md-8 d-flex justify-content-between">
                    <span>{{ $user->dob }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Address:</strong></div>
                <div class="col-md-8 d-flex justify-content-between">
                    <span>{{ $user->address }}</span>
                </div>
            </div>
            @if($user->account_type == 'photographer')
                @include('myprofile-photographer')
            @else
                @include('myprofile-client')
            @endif
        </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDzwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Script for Navbar Background Change -->
    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

    function editField(editBtn) {
        const parentDiv = editBtn.parentNode;
        const dataSpan = parentDiv.querySelector('.data');
        const inputField = parentDiv.querySelector('.edit-field');

        if (dataSpan.style.display === 'none') {
            dataSpan.style.display = 'inline';
            inputField.style.display = 'none';
        } else {
            dataSpan.style.display = 'none';
            inputField.style.display = 'inline';
            inputField.focus();
        }

        inputField.addEventListener('input', function() {
            document.getElementById('editAccountBtn').disabled = false;
        });
    }

    document.querySelectorAll('.edit-field').forEach(function(input) {
        input.addEventListener('input', function() {
            const formField = document.getElementById(input.name);
            formField.value = input.value;
            document.getElementById('editAccountBtn').disabled = false;
        });
    });
</script>

</body>

</html>

