<!-- Navigation Bar -->
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-blue-600">MiniMarket</a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="/admin/dashboard" class="text-gray-700 hover:text-blue-600 {{ request()->is('admin/dashboard') ? 'text-blue-600' : '' }}">Dashboard</a>
                <a href="/admin/products" class="text-gray-700 hover:text-blue-600 {{ request()->is('admin/products*') ? 'text-blue-600' : '' }}">Products</a>
                <a href="/admin/profile" class="text-gray-700 hover:text-blue-600 {{ request()->is('admin/profile') ? 'text-blue-600' : '' }}">Profile</a>
                <a href="/admin/orders" class="text-gray-700 hover:text-blue-600 {{ request()->is('admin/orders') ? 'text-blue-600' : '' }}">Orders</a>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="text-white bg-red-600 px-4 py-2 rounded-md hover:text-red-700">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your account!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }
</script> 