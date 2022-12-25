<div class="row">
    <nav class="navbar navbar-dark bg-primary" aria-label="First navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Never expand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample01">
                <ul class="navbar-nav me-auto mb-2">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
        </div>
    </nav>
</div>
<div class="row">
    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark vh-100">
        <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                        <span data-feather="home" class="align-text-bottom"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file" class="align-text-bottom"></span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="users" class="align-text-bottom"></span>
                        Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('employees')}}">
                        Karyawan
                    </a>
                </li>
            </ul>
        </div>
    </nav>