<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.kategori') }}">
            Kategori
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.produk') }}">
            Produk
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.transaksi') }}">
            Transaksi
        </a>
    </li>
</ul>
