
@extends('layouts.app')

@section('content')
    
    <!-- Hero Section -->
    <div class="bg-green-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to MiniMarket</h1>
            <p class="text-xl mb-8">Your one-stop shop for all your daily needs</p>
            <button class="bg-white text-green-600 px-8 py-3 rounded-md text-lg font-semibold hover:bg-green-50">
                Shop Now
            </button>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x300" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                            <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                        <div class="mt-2">
                            {{-- <small class="text-muted">Stock: {{ $product->stock }}</small> --}}
                        </div>
                        <div class="mt-3">
                            {{-- <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a> --}}
                            <div class="flex items-center justify-between">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline add-to-cart-form" data-product-id="{{ $product->id }}">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>

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

        // Add to Cart AJAX functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartForms = document.querySelectorAll('.add-to-cart-form');
            
            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    
                    // Disable button and show loading state
                    submitButton.disabled = true;
                    submitButton.textContent = 'Adding...';
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Product added to cart successfully!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    })
                    .catch(error => {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to add product to cart.',
                            icon: 'error'
                        });
                    })
                    .finally(() => {
                        // Reset button state
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    });
                });
            });
        });
    </script>
@endsection
