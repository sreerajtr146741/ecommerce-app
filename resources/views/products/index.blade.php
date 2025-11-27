<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Products - MyStore</title>

    <!-- BACK BUTTON & CACHE KILLER (NEVER GO BACK TO OLD CART STATE) -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .top-navbar {
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .user-avatar {
            width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 3px solid #0d6efd;
            cursor: pointer;
        }
        .dropdown-menu { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: none; }
        .product-card { cursor: pointer; transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15)!important; }
        .product-image { height: 220px; object-fit: cover; width: 100%; }
        .placeholder-img { height: 220px; display: flex; align-items: center; justify-content: center; background: #f1f3f5; flex-direction: column; }
        .detail-image { max-height: 520px; object-fit: contain; background: white; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .price { font-size: 2.8rem; font-weight: bold; color: #d32f2f; }
        .old-price { text-decoration: line-through; color: #878787; font-size: 1.3rem; }
        .discount { background: #388e3c; color: white; padding: 6px 14px; border-radius: 8px; font-weight: bold; font-size: 1.1rem; }
        .btn-add-cart { background: #ff9f00; color: white; font-weight: bold; padding: 16px 50px; border-radius: 10px; font-size: 1.2rem; }
        .btn-add-cart:hover { background: #f57c00; }
        .btn-buy-now { background: #fb641b; color: white; font-weight: bold; padding: 16px 50px; border-radius: 10px; font-size: 1.2rem; }
        .btn-buy-now:hover { background: #e55a15; }
        .btn-success { background: #28a745 !important; }
        .checkout-btn { font-size: 0.9rem; padding: 8px 16px; }
    </style>
</head>
<body>

<!-- EVERYTHING BELOW IS 100% UNCHANGED — YOUR FULLY WORKING CART & PRODUCTS PAGE -->
<nav class="top-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <h2 class="mb-0 fw-bold text-primary">MyStore</h2>
        </a>

        <div class="d-flex align-items-center gap-4">

            <!-- SMART CART: Purchased = Removed | Failed/Cancelled = Stays -->
            <div class="dropdown">
                <a class="text-dark fs-3 position-relative" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cart3"></i>
                    @php
                        $rawCart = session('cart', []);
                        $purchased = session('purchased_items', []);
                        $cart = array_diff_key($rawCart, array_flip($purchased));
                        $cartCount = count($cart);
                        session(['cart' => $cart]);
                    @endphp
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end p-3" style="width: 420px; max-height: 80vh; overflow-y: auto;">
                    <li class="text-center fw-bold text-primary fs-5 mb-3">MY CART ({{ $cartCount }})</li>
                    <li><hr class="dropdown-divider"></li>

                    @if($cartCount > 0)
                        @foreach($cart as $id => $item)
                            <li class="mb-4 pb-3 border-bottom">
                                <div class="d-flex align-items-start gap-3">
                                    <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://img.icons8.com/ios-filled/80/0d6efd/box.png' }}"
                                         class="rounded shadow-sm" width="80" height="80" style="object-fit: cover;">

                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ Str::limit($item['name'], 40) }}</h6>
                                        <p class="text-success fw-bold fs-4 mb-3">${{ number_format($item['price'], 2) }}</p>

                                        <a href="{{ route('checkout.single', $id) }}" 
                                           class="btn btn-warning btn-sm checkout-btn w-100 mb-2">
                                            Checkout This Item
                                        </a>
                                    </div>

                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm text-danger p-0">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach

                        <li class="text-center pt-3">
                            <a href="{{ route('checkout.all') }}" class="btn btn-success btn-lg w-100">
                                Checkout All Items ({{ $cartCount }})
                            </a>
                        </li>
                    @else
                        <li class="text-center py-5 text-muted">
                            <i class="bi bi-cart-x display-3 text-muted"></i>
                            <p class="mt-3 fs-5">Your cart is empty</p>
                            <small>Start adding products!</small>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- USER AVATAR -->
            <div class="dropdown">
                <a href="#" role="button" data-bs-toggle="dropdown">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="user-avatar" alt="Profile">
                    @else
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center user-avatar fw-bold fs-4">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header text-primary fw-bold">Welcome!</li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="{{ route('products.index') }}">My Products ({{ auth()->user()->products()->count() }})</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('edit.profile') }}">Edit Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- REST OF YOUR PAGE 100% UNCHANGED -->
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(request()->route('product'))
        @php $product = request()->route('product'); @endphp
        <div class="row g-5">
            <div class="col-lg-6 text-center">
                @if($product->image && \Storage::disk('public')->exists($product->image))
                    <img src="{{ asset('storage/' . $product->image) }}" class="detail-image img-fluid" alt="{{ $product->name }}">
                @else
                    <div class="bg-light d-inline-block p-5 rounded shadow">
                        <img src="https://img.icons8.com/ios-filled/200/0d6efd/box.png" alt="No image">
                        <p class="mt-3 text-muted">No Image Available</p>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold display-5 mb-3">{{ $product->name }}</h1>
                <div class="mb-3">
                    <span class="badge bg-secondary fs-5 px-4 py-2">{{ $product->category ?? 'Uncategorized' }}</span>
                </div>
                <div class="mb-4">
                    <span class="price">${{ number_format($product->price, 2) }}</span>
                    <span class="old-price ms-3">$ {{ number_format($product->price * 1.5, 2) }}</span>
                    <span class="discount ms-3">33% off</span>
                </div>
                <p class="text-muted fs-5 lh-lg">{{ $product->description ?: 'No description available.' }}</p>

                <div class="d-flex flex-wrap gap-3 mt-5">
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ session('cart') && array_key_exists($product->id, session('cart', [])) ? 'btn-success' : 'btn-add-cart' }} shadow-lg px-5">
                            @if(session('cart') && array_key_exists($product->id, session('cart', [])))
                                Added to Cart
                            @else
                                Add to Cart
                            @endif
                        </button>
                    </form>
                    <button class="btn btn-buy-now shadow-lg px-5">Buy Now</button>
                </div>

                <div class="mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg px-5">Back to Products</a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-dark">My Products</h1>
            <a href="{{ route('products.create') }}" class="btn btn-success btn-lg shadow-sm px-4">Add New Product</a>
        </div>

        @if($myProducts->count() > 0)
            <div class="row g-4">
                @foreach($myProducts as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 product-card">
                                @if($product->image && \Storage::disk('public')->exists($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                                @else
                                    <div class="placeholder-img">
                                        <img src="https://img.icons8.com/ios-filled/80/0d6efd/box.png">
                                        <small class="text-muted mt-2">No photo</small>
                                    </div>
                                @endif
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-2">{{ $product->name }}</h5>
                                    <p class="text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                    <h4 class="text-success mt-3">${{ number_format($product->price, 2) }}</h4>
                                </div>
                                <div class="px-4 pb-4 d-flex justify-content-between">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 my-5">
                <h3 class="mt-4 text-muted">You haven't added any products yet</h3>
                <a href="{{ route('products.create') }}" class="btn btn-success btn-lg px-5 mt-3">Add Your First Product</a>
            </div>
        @endif
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>