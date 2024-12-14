<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Navbar Brand -->
        <a class="navbar-brand" href="{{ url('/') }}">E-commerce</a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Konten Navbar Lain -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Dropdown Kategori -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($kategoris as $kategori)
                                <li>
                                    <a class="dropdown-item" href="{{ route('produk.byKategori', $kategori->id) }}">
                                        {{ $kategori->nama }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- Dropdown Produk Terlaris -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="bestSellingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produk Terlaris
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="bestSellingDropdown">
                            @foreach($bestSellingProducts as $product)
                                <li>
                                    <a class="dropdown-item" href="{{ route('produk.show', $product->id) }}">
                                        {{ $product->nama }} - {{ $product->sold }} terjual
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- Dropdown Produk Rekomendasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="recommendedDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produk Rekomendasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="recommendedDropdown">
                            @foreach($recommendedProducts as $product)
                                <li>
                                    <a class="dropdown-item" href="{{ route('produk.show', $product->id) }}">
                                        {{ $product->nama }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>



        <!-- Pencarian Produk -->
        <form class="d-flex mx-auto" method="GET" action="{{ route('search') }}">
            <input class="form-control me-2" type="search" name="query" placeholder="Cari produk..." aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Cari</button>
        </form>

        <!-- Cart Icon with Badge -->
        <a href="{{ route('carts.index') }}" class="nav-link">
            <i class="fa fa-shopping-cart" style="font-size: 24px;"></i>
            @if($cartCount > 0) <!-- Check if cart has items -->
                <span class="badge bg-danger rounded-pill">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        <!-- Navbar Links -->
        <ul class="navbar-nav ms-auto">
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>

    </div>
</nav>
