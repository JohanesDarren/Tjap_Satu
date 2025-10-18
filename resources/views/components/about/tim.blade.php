<!-- Pemilik Bisnis -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold text-uppercase" style="color:#ff5500" data-aos="zoom-in" data-aos-duration="1000">Pemilik Bisnis</h2>

    <div class="row g-4 justify-content-center">
        @foreach ($owners as $owner)
        <div class="col-md-3 text-center" data-aos="flip-left" data-aos-delay="{{ $loop->index * 300 }}" data-aos-duration="1000">
          <div class="owner-card shadow p-3">
              <img src="{{ asset('images/' . $owner['image']) }}" alt="{{ $owner['name'] }}" class="owner-img mb-3">
              <h5 class="fw-bold">{{ $owner['name'] }}</h5>
              <small class="text-muted">{{ $owner['position'] }}</small>
              <p class="mt-2">{{ $owner['desc'] }}</p>
          </div>
        </div>
        @endforeach
    </div>
  </div>
</section>
