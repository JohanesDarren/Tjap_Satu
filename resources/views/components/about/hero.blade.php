<!-- HERO SECTION -->
<section class="hero-section position-relative text-white" style="height: 100vh; overflow: hidden;">

  <!-- Video Background -->
  <video autoplay muted loop playsinline class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
    <source src="{{ asset('videos/heroes.mp4') }}" type="video/mp4">
    Browser kamu tidak mendukung video HTML5.
  </video>

  <!-- Overlay gradasi -->
  <div class="overlay position-absolute top-0 start-0 w-100 h-100"
       style="background: linear-gradient(to top, rgba(60, 30, 10, 0.8), rgba(0, 0, 0, 0.4)); z-index:1;">
  </div>

  <!-- Konten teks di atas video -->
  <div class="container position-relative h-100 d-flex flex-column justify-content-end align-items-start text-start pb-5" 
       data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" style="z-index:2;">
    <h1 class="display-5 fw-bold mb-3">
      Mari Menyeduh <span>Cerita</span> di<br> 
      Seluruh <span>Bandung</span>
    </h1>
    <p class="fs-5">
      Jadilah bagian dari perjalanan kopi nomor satu — TJAP SATU.
    </p>
  </div>

</section>

<!-- Style tambahan agar video tetap proporsional -->
<style>
  .hero-section video {
    object-fit: cover;
    filter: brightness(90%);
  }
  .hero-section span {
    color: #ff8a33;
  }
</style>
