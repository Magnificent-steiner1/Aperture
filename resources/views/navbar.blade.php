<style>
    /* Navbar */
    .navbar {
        background-color: #1a1a1a; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
    }

    .navbar-brand img {
        max-height: 40px; 
    }

    .navbar-nav .nav-link {
        color: #ffffff; 
        font-weight: 500; 
        transition: color 0.3s ease; 
        font-family: 'Poppins', sans-serif; 
        margin: 0 15px; 
    }

    .navbar-nav .nav-link:hover {
        color: yellow; 
    }


    .form-inline .form-control {
        width: 300px;
        padding-right: 40px; 
        background-color: #262626; 
        border-color: transparent; 
        color: #ffffff;
    }

    .form-inline .btn-search {
        background-color: transparent; 
        border: none; 
        padding: 0; 
        cursor: pointer; 
        color: #ffffff; 
    }

    .form-inline .btn-search:hover {
        color: #66D37E; 
    }

    .profile-photo {
        width: 35px;
        height: 35px;
        border-radius: 50%; 
        object-fit: cover;
        margin-left: 10px; 
    }


    .dropdown-menu {
        background-color: #1a1a1a; 
        border: none; 
    }

    .dropdown-menu .dropdown-item {
        color: #ffffff; 
        font-family: 'Poppins', sans-serif; 
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #66D37E; 
    }
</style>




<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{ asset('/images/logo/logo-main2.png') }}" alt="Aperture"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                @if(auth()->check())
                    @if(auth()->user()->isPhotographer())
                        <li class="nav-item">
                            <a class="nav-link" href="#">Find Work</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/offers">Offers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/active-contracts">Active Contracts</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/photographers">Find Photographer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Post Contract</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/active-contracts">Active Contracts</a>
                        </li>
                    @endif
                @else

                
                    <li class="nav-item">
                        <a class="nav-link" href="#">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/photographers">Photographers</a>
                    </li>
                @endif
            </ul>

            
            <form class="form-inline">
                <div class="input-group">
                    <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-light btn-search" type="submit">
                        <i class="bi bi-search search-icon"></i>
                    </button>
                </div>
            </form>


            <ul class="navbar-nav ml-auto">
                @if(!auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Signup</a>
                    </li>
                @endif
               

                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @if(auth()->user()->account_type == 'photographer' && auth()->user()->photographer)
                                <img src="{{ asset('storage/' . auth()->user()->photographer->profile_photo) }}" alt="Profile Photo" class="profile-photo" style="width: 35px; height: 35px;">
                            @elseif(auth()->user()->account_type == 'client' && auth()->user()->client)
                                <img src="{{ asset('storage/' . auth()->user()->client->profile_photo) }}" alt="Profile Photo" class="profile-photo" style="width: 35px; height: 35px;">
                            @else
                                <img src="https://via.placeholder.com/35" alt="Profile Photo" class="profile-photo" style="width: 35px; height: 35px;">
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/myprofile">My Profile</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
