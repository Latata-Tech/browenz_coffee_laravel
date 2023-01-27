<div class="row">
    <nav class="navbar navbar-dark bg-primary" aria-label="First navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Never expand</a>
            <div class="dropdown">
                <button class="btn dropdown-toggle" style="margin-right:130px" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <span class="material-icons">account_circle</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">
                            <form action="{{ route('logout') }}" method="POST">
                                @method('POST')
                                @csrf
                                <button type="submit" class="btn btn-logout stretched-link">Logout</button>
                            </form>
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="row">
    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark vh-100">
        <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="#">
                        <span data-feather="home" class="align-text-bottom"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span data-feather="file" class="align-text-bottom"></span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{route('ingredients')}}">
                        <span data-feather="users" class="align-text-bottom"></span>
                        Stok
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{route('employees')}}">
                        Karyawan
                    </a>
                </li>
            </ul>
        </div>
    </nav>
