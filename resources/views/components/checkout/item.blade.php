@foreach ($cartItems as $item)
    <div class="card mb-3 p-3" style="border: none;">
        <div class="row g-3 align-items-center">
            <div class="col-3">
                <img src="{{ $item['image'] }}" class="img-fluid" alt="{{ $item['name'] }}">
            </div>
            <div class="col-5">
                <h6 class="mb-1">{{ $item['name'] }}</h6>
                <p class="text-muted mb-1">{{ $item['description'] }}</p>
                <p class="mb-1">{{ $item['satuan'] }}</p>
            </div>
            <div class="col-2 text-end">
                <span class="fw-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
            </div>
            <div class="col-2 d-flex align-items-center">
                <button class="btn btn-outline-secondary btn-sm me-1">-</button>
                <input type="text" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}"
                    style="width: 50px;">
                <button class="btn btn-outline-secondary btn-sm ms-1">+</button>
                <button class="btn btn-link text-danger ms-2"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    </div>
@endforeach
