<!doctype html>
<html lang="en">

<head>
    <title>Photographers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            padding-top: 56px;
        }

        .photographer-card {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .photographer-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .photographer-info h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .photographer-info p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .photographer-skill {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .hire-btn {
            background-color: #66d37e;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hire-btn:hover {
            background-color: #083836;
        }

        .modal-body label {
            margin-top: 0.5rem;
        }

        .modal-footer button {
            margin-top: 1rem;
        }

        .distance-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    @include('navbar')

    <div class="container mt-4">
        <div class="row">
            @foreach ($photographers as $photographer)
            <div class="col-md-6">
                <div class="photographer-card d-flex">
                    <img src="{{ $photographer->profile_photo ? asset('storage/' . $photographer->profile_photo) : 'https://via.placeholder.com/80' }}" alt="Profile Photo" class="photographer-photo">
                    <div class="photographer-info">
                        <h2>{{ $photographer->name }}</h2>
                        <p>{{ $photographer->skill1 }} @if($photographer->skill2), {{ $photographer->skill2 }} @endif @if($photographer->skill3), {{ $photographer->skill3 }} @endif</p>
                        <p>Rating: {{ $photographer->rating ? $photographer->rating : 'Not rated' }}</p>
                        <p class="distance-info">Distance: {{ $photographer->distance }} km</p>
                        @if (in_array($photographer->photographer_id, $pendingJobs))
                            <button class="hire-btn" disabled>Sent Offer</button>
                        @else
                            @if (Auth::check())
                                <button class="hire-btn" data-bs-toggle="modal" data-bs-target="#hireModal{{ $photographer->photographer_id }}">Hire</button>
                            @else
                                <a href="{{ route('login') }}" class="hire-btn">Hire</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hire Modal -->
            <div class="modal fade" id="hireModal{{ $photographer->photographer_id }}" tabindex="-1" aria-labelledby="hireModalLabel{{ $photographer->photographer_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('send.offer', $photographer->photographer_id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="hireModalLabel{{ $photographer->photographer_id }}">Hire {{ $photographer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="type">Type of Photography:</label>
                                <input type="text" name="type" class="form-control" required>
                                <label for="description">Description:</label>
                                <textarea name="description" class="form-control" required></textarea>
                                <label for="date">Date:</label>
                                <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                <label for="duration">Duration (hrs):</label>
                                <input type="number" name="duration" class="form-control" required>
                                <label for="salary">Salary:</label>
                                <input type="number" step="0.01" name="salary" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="hire-btn">Send Offer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDzwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
