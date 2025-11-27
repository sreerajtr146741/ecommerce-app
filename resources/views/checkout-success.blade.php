<!DOCTYPE html>
<html>
<head><title>Success!</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success text-white">
<div class="container text-center py-5" style="margin-top: 15vh;">
    <i class="bi bi-check-circle display-1"></i>
    <h1 class="display-4 mt-4">Payment Successful!</h1>
    <p class="lead">Your order has been placed. Items removed from cart.</p>
    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg mt-4">Continue Shopping</a>
</div>
</body>
</html>