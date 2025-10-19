<div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th></th>
          <th>PRODUK</th>
          <th>HARGA</th>
          <th>JUMLAH</th>
          <th>TOTAL HARGA</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($cartItems as $item)
        <tr>
          <td>
            <input type="checkbox" class="form-check-input item-checkbox">
          </td>
          <td>
            <div class="d-flex align-items-center">
              <img src="{{ $item['image'] }}" class="cart-img me-3" alt="">
              <span>{{ $item['name'] }}</span>
            </div>
          </td>
          <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
          <td>
  <div class="input-group quantity-group" style="width: 120px;">
    <button class="btn btn-outline-secondary btn-decrease" type="button">−</button>
    <input type="text" value="{{ $item['quantity'] }}" class="form-control text-center qty-input" readonly>
    <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
  </div>
</td>

          <td class="text-danger fw-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
          <td><button class="btn btn-outline-danger btn-sm">×</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>