<div class="row">
    <nav class="navbar navbar-dark bg-primary" aria-label="First navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{asset('images/logo.png')}}" width="35" height="35">&nbsp;Browenz POS</a>
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center text-white" style="margin-right:130px" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <span class="material-icons">account_circle</span>&nbsp;
                    {{auth()->user()->name}}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('changePassword')}}">Ubah Password</a></li>
                    <li><a class="dropdown-item" href="#" onclick="trigerLogout()">Logout</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <form action="{{ route('logout') }}" method="POST">
        @method('POST')
        @csrf
        <button type="submit" class="btn btn-logout stretched-link dropdown-item d-none" id="btnLogout">Logout</button>
    </form>
</div>
<div class="row">
    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark vh-100">
        <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active nav-text-color d-flex align-items-center" aria-current="page" href="{{route('dashboard')}}">
                        <span class="material-icons">dashboard</span>&nbsp;
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active nav-text-color d-flex align-items-center" aria-current="page" href="{{route('sellings')}}">
                        <span class="material-icons">point_of_sale</span>&nbsp;Penjualan
                    </a>
                </li>
                <li class="mb-1 nav-item">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed nav-link nav-text-color dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                        <span class="material-icons">book</span>&nbsp;
                        Produk
                    </button>
                    <div class="collapse" style="padding-left: 10px" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('menus')}}" class="link-body-emphasis d-inline-flex text-decoration-none rounded nav-link nav-text-color">
                                    <span class="material-icons">book</span>&nbsp;
                                    Menu
                                </a></li>
                            <li><a href="{{route('categories')}}" class="link-body-emphasis d-inline-flex text-decoration-none rounded nav-link nav-text-color">
                                    <span class="material-icons">book</span>&nbsp;
                                    Kategori
                                </a></li>
                            <li><a href="{{route('promos')}}" class="link-body-emphasis d-inline-flex text-decoration-none rounded nav-link nav-text-color">
                                    <span class="material-icons">book</span>&nbsp;
                                    Promo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1 nav-item">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed nav-link nav-text-color dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#ingredients-collapse" aria-expanded="false">
                        <span class="material-icons">warehouse</span>&nbsp;
                        Bahan Baku
                    </button>
                    <div class="collapse" style="padding-left: 10px" id="ingredients-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('ingredients')}}" class="link-body-emphasis d-inline-flex text-decoration-none rounded nav-link nav-text-color">
                                    <span class="material-icons">warehouse</span>&nbsp;
                                    Daftar Bahan Baku
                                </a></li>
                            <li><a href="{{route('transactions')}}" class="link-body-emphasis d-inline-flex text-decoration-none rounded nav-link nav-text-color">
                                    <span class="material-icons">warehouse</span>&nbsp;
                                    Transaksi Stok
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-text-color d-flex align-items-center" href="{{route('reports')}}">
                        <span class="material-icons">insert_chart</span>&nbsp;
                        Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-text-color d-flex align-items-center" href="{{route('employees')}}">
                        <span class="material-icons">manage_accounts</span>&nbsp;
                        Karyawan
                    </a>
                </li>
            </ul>
        </div>
    </nav>
