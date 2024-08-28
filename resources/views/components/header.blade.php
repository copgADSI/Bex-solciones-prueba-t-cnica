<header>
    <nav class="navbar bg-primary navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('visits.onMap') }}">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="text-white nav-link" aria-current="page" href="{{ route('visits.index') }}">
                            Visits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="text-white nav-link " aria-current="page" href="{{ route('visits.onMap') }} ">Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="text-white nav-link " aria-current="page" href="{{ route('auth.logout') }}">Logout</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>
