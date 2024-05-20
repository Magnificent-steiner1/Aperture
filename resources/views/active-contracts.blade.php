<!doctype html>
<html lang="en">
<head>
    <title>Active Contracts</title>
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

        .contract-card {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .contract-card h5 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .contract-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .contract-card .contract-details {
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            margin-top: 1rem;
        }

        .contract-card .contract-details p {
            margin-bottom: 0.5rem;
        }

        .contract-card .contract-actions {
            margin-top: 1rem;
        }

        .contract-card .contract-actions button {
            margin-right: 1rem;
        }
    </style>
</head>

<body>
    @include('navbar')

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Active Contracts</h1>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if($contracts->count() > 0)
                @foreach($contracts as $contract)
                <div class="contract-card">
                    <h5>{{ $contract->type }}</h5>
                    <div class="contract-details">
                        <p><strong>Description:</strong> {{ $contract->description }}</p>
                        <p><strong>Date:</strong> {{ $contract->date }}</p>
                        <p><strong>Duration:</strong> {{ $contract->duration }} hours</p>
                        <p><strong>Salary:</strong> {{ $contract->salary }} BDT</p>
                        @if($userType === 'client')
                        <p><strong>Photographer:</strong> {{ $contract->photographer->account->name }}</p>
                        @endif
                    </div>
                    <div class="contract-actions">
                        @if($userType === 'photographer')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelContractModal{{ $contract->job_id }}">Cancel Contract</button>
                        @elseif($userType === 'client')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#endContractModal{{ $contract->job_id }}">End Contract</button>
                        @endif
                    </div>
                </div>

                <!-- Cancel Contract Modal -->
                @if($userType === 'photographer')
                <div class="modal fade" id="cancelContractModal{{ $contract->job_id }}" tabindex="-1" aria-labelledby="cancelContractModalLabel{{ $contract->job_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelContractModalLabel{{ $contract->job_id }}">Cancel Contract</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to cancel this contract?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('active-contracts.cancel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $contract->job_id }}">
                                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep it</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- End Contract Modal -->
                @if($userType === 'client')
                <div class="modal fade" id="endContractModal{{ $contract->job_id }}" tabindex="-1" aria-labelledby="endContractModalLabel{{ $contract->job_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="endContractModalLabel{{ $contract->job_id }}">End Contract</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Ending the contract means the job is completed. You have to pay the full salary. Are you sure?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('active-contracts.end') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $contract->job_id }}">
                                    <button type="submit" class="btn btn-danger">Yes, End</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep it</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
                @else
                <p class="text-center">No active contracts.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
