<!DOCTYPE html>
<html>
<head>
    <title>Checkout - MyStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2>Complete Your Order</h2>
                </div>
                <div class="card-body p-5">
                    @if(isset($item))
                        <div class="text-center mb-4">
                            <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : 'https://img.icons8.com/ios-filled/200/0d6efd/box.png' }}" 
                                 width="120" class="rounded shadow">
                            <h4 class="mt-3">{{ $item['name'] }}</h4>
                            <h3 class="text-success">${{ number_format($item['price'], 2) }}</h3>
                        </div>
                    @else
                        <h4>You are checking out {{ count($items) }} item(s)</h4>
                        @foreach($items as $i)
                            <div class="d-flex align-items-center mb-3 p-3 bg-white rounded shadow-sm">
                                <img src="{{ $i['image'] ? asset('storage/'.$i['image']) : '' }}" width="60" class="rounded me-3">
                                <div>
                                    <h6>{{ $i['name'] }}</h6>
                                    <strong class="text-success">${{ number_format($i['price'], 2) }}</strong>
                                </div>
                            </div>
                        @endforeach
                        <h3 class="text-end mt-4">Total: ${{ number_format(collect($items)->sum('price'), 2) }}</h3>
                    @endif

                    <div class="text-center mt-5">
                        <form action="{{ route('checkout.success') }}" method="GET">
                            @if(isset($item))
                                <input type="hidden" name="purchased_ids[]" value="{{ $item['id'] }}">
                            @else
                                @foreach($items as $i)
                                    <input type="hidden" name="purchased_ids[]" value="{{ $i['id'] }}">
                                @endforeach
                            @endif
                            <button class="btn btn-success btn-lg px-5">Pay Now </button>
                        </form>
                        <a href="{{ route('checkout.cancel') }}" class="btn btn-danger btn-lg px-5 mt-3">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>