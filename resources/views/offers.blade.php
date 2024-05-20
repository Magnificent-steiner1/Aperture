<!doctype html>
<html lang="en">

<head>
    <title>Offers</title>
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

        .offer-card {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .offer-info h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .offer-info p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .modal-body label {
            margin-top: 0.5rem;
        }

        .modal-footer button {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    @include('navbar')

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Offers</h1>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        @if($offers->count() > 0)
                            <ul class="list-group">
                                @foreach($offers as $offer)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h5>{{ $offer->type }}</h5>
                                        <div>
                                            <span class="badge bg-secondary">Offered by: {{ $offer->client->account->name }}</span>
                                            <span class="badge bg-primary">{{ $offer->date }}</span>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#offerDetailsModal{{ $offer->id }}">Show Details</a>
                                        </div>
                                    </li>
                                    <!-- Offer Details Modal -->
                                    <div class="modal fade" id="offerDetailsModal{{ $offer->id }}" tabindex="-1" aria-labelledby="offerDetailsModalLabel{{ $offer->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="offerDetailsModalLabel{{ $offer->id }}">Offer Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Type:</strong> {{ $offer->type }}</p>
                                                    <p><strong>Description:</strong> {{ $offer->description }}</p>
                                                    <p><strong>Date:</strong> {{ $offer->date }}</p>
                                                    <p><strong>Duration:</strong> {{ $offer->duration }} hours</p>
                                                    <p><strong>Salary:</strong> {{ $offer->salary }} BDT</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('offers.accept') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Accept</button>
                                                    </form>
                                                    <form action="{{ route('offers.ignore') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary">Ignore</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center">No offers available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
