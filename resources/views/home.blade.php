@extends('layout.main')

@section("contents")
<main class="main">
  <!-- Hero Section -->
  <section class="cover-bg vh-100 d-flex align-items-center justify-content-center text-white">
    <div class="overlay" ></div>
  </section>

  <!-- About Section -->
  <section id="about" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>HealthyHair</h2>
      <p>Sistem rekomendasi untuk membantu Anda mendapatkan rambut yang lebih sehat dan kuat.</p>
    </div><!-- End Section Title -->
    
    <div class="container">
    
      <div class="row gy-4">
        <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="300"
        data-aos-easing="ease-in-sine">
          <img src="../img/About Pict.jpg" class="img-fluid" style="width: 90%;height:80%" alt="Healthy Hair">
        </div>
        <div class="col-md-6 content" data-aos="fade-Left" data-aos-duration="1500" data-aos-offset="300"
        data-aos-easing="ease-in-sine">
          <h3>Mengapa Menggunakan Sistem Rekomendasi Perawatan Rambut?</h3>
          <p>
            Menemukan rutinitas perawatan rambut yang tepat bisa menjadi tantangan. HealthyHair membantu Anda memilih produk dan perawatan terbaik yang disesuaikan dengan jenis dan kebutuhan rambut Anda.
          </p>
          <ul>
            <li><i class="bi bi-check2-all"></i> <span>Rekomendasi personal berdasarkan jenis rambut dan permasalahan Anda.</span></li>
            <li><i class="bi bi-check2-all"></i> <span>Saran yang didukung oleh ahli untuk kesehatan dan perawatan rambut yang lebih baik.</span></li>
            <li><i class="bi bi-check2-all"></i> <span>Tidak perlu lagi coba-coba—temukan produk yang benar-benar cocok untuk Anda.</span></li>
          </ul>
          <p>
            Baik Anda memiliki rambut kering, berminyak, keriting, atau lurus, HealthyHair menyediakan solusi yang disesuaikan agar rambut Anda tetap sehat, berkilau, dan kuat.
          </p>
          <div class="mt-4 alert bg-white" role="alert">
              Total rekomendasi yang diberikan adalah <strong>{{ $totalRekomendasi }}</strong> dengan memiliki ketepatan rekomendasi (precision) sebesar <strong>{{ $averagePrecision }}</strong>.
          </div>
        </div>
        
      </div>
    
  </section><!-- /About Section -->

  <!-- Features Section -->
  <section id="features" class="features section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Our Concern About Hair</h2>
    </div><!-- End Section Title -->
    
      <div class="container">
        <div class="row g-4">
          <!-- Jenis Rambut -->
          <div class="col-lg-4 col-md-6" data-aos="flip-up" data-aos-delay="100">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center">
                <div class="mb-3 fs-2 text-primary"><i class="bi bi-check2-all"></i></div>
                <h5 class="card-title fw-bold">Jenis Rambut</h5>
                <p class="card-text text-start">
                  Terdapat 3 jenis rambut utama:<br>
                  <strong>Lurus</strong> - Mudah diatur, lebih cepat berminyak.<br>
                  <strong>Bergelombang</strong> - Kombinasi antara lurus dan keriting, sering membutuhkan hidrasi.<br>
                  <strong>Keriting</strong> - Rentan kering, perlu perawatan ekstra dengan pelembap.
                </p>
              </div>
            </div>
          </div>
        
          <!-- Masalah Rambut -->
          <div class="col-lg-4 col-md-6" data-aos="flip-up" data-aos-delay="200">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center">
                <div class="mb-3 fs-2 text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                <h5 class="card-title fw-bold">Masalah Rambut</h5>
                <p class="card-text text-start">
                  🔹 Rambut rontok.<br>
                  🔹 Rambut kering.<br>
                  🔹 Rambut berminyak.<br>
                  🔹 Rambut berwarna.
                </p>
              </div>
            </div>
          </div>
        
          <!-- Aktivitas Sehari-hari -->
          <div class="col-lg-4 col-md-6" data-aos="flip-up" data-aos-delay="300">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center">
                <div class="mb-3 fs-2 text-warning"><i class="bi bi-lightning-charge"></i></div>
                <h5 class="card-title fw-bold">Aktivitas Sehari-hari</h5>
                <p class="card-text text-start">
                  Aktivitas sehari-hari dapat membuat rambut menjadi kotor dan menyebabkan berbagai masalah rambut.
                </p>
              </div>
            </div>
          </div>
        </div>
        </div>
      </section>
      


</main>
@endsection