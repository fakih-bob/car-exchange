
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Admin Panel</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}">Manage Drivers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin2/listOrders">Orders</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin2/listLoyalties">Loyalties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/reports">Reports</a>
                </li>

            </ul>
        </div>
    </div>
</nav>



