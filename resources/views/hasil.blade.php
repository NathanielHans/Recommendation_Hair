@extends('layout.main')

@section('contents')
<main class="main">
    <section id="recommendations" class="section">
        <div class="container">
            <h2 class="text-center mb-4">Hasil Rekomendasi Produk</h2>
            <h2>Rekomendasi Produk</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                
                @if (!empty($recommendations))
                @foreach ($recommendations as $index => $product)
                <div class="my-3 justify-content-center col-sm-6 col-md-3 col-lg-3">
                    <div class="card p-2 justify-content-center product-card" data-bs-toggle="modal" data-bs-target="#productModal" data-index="{{ $index }}"
                         data-name="{{ $product['Name'] }}" data-ingridients="{{ $product['Ingredients'] ?? 'Tidak ada Ingredients' }}" 
                         data-price="Rp.{{ isset($product['Price']) 
                                    ? number_format((int) preg_replace('/[^\d]/', '', $product['Price']), 0, ',', '.') 
                                    : 'N/A' }}" data-link = "{{ $product["Link"] }}">
                        <div style="text-align:left" class="deskripsi card-body">
                            <h5 class="card-title">{{ $product['Brand'] }}</h5>
                            <h6 class="card-title">{{ $product['Name'] }}</h6>
                            {{-- <p class="card-text">{{ $product['Ingredients'] ?? 'Tidak ada deskripsi' }}</p> --}}
                            <p class="card-text2">
                                Rp. {{ isset($product['Price']) 
                                    ? number_format((int) preg_replace('/[^\d]/', '', $product['Price']), 0, ',', '.') 
                                    : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <p>Tidak ada rekomendasi ditemukan.</p
                @endif
            </div>
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Detail Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 id="modalProductName"></h5>
                            <p id="modalProductIngridients"></p>
                            <p id="modalProductPrice" class="fw-bold"></p>
                            <p><a href="#" target="_blank" id="modalProductLink" class="fw-bold">Lihat Produk</a></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="likeButton" class="btn btn-outline-primary">Like Produk Ini</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <form id="feedback-form" method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <input type="hidden" name="precision" id="precision-input">
                <button type="submit" class="btn btn-success mt-4">Submit Precision</button>
            </form>
        </div>
    </section>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productCards = document.querySelectorAll(".product-card");

        productCards.forEach(card => {
            card.addEventListener("click", function () {
                document.getElementById("modalProductName").textContent = this.getAttribute("data-name");
                document.getElementById("modalProductIngridients").textContent = this.getAttribute("data-ingridients");
                document.getElementById("modalProductPrice").textContent = this.getAttribute("data-price");
                const link = this.getAttribute("data-link");
                document.getElementById("modalProductLink").innerHTML = `<a href="${link}" target="_blank" class="text-decoration-underline text-primary">Lihat Produk</a>`;
            });
        });
    });
</script>
<script>
    const likes = new Array({{ count($recommendations) }}).fill(false);
    let currentIndex = null;

    const modal = document.getElementById('productModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const card = event.relatedTarget;
        currentIndex = parseInt(card.getAttribute('data-index'));

        document.getElementById('modalProductName').textContent = card.getAttribute('data-name');
        document.getElementById('modalProductIngridients').textContent = card.getAttribute('data-ingredients');
        document.getElementById('modalProductPrice').textContent = card.getAttribute('data-price');
        document.getElementById('modalProductLink').href = card.getAttribute('data-link');

        // Update tombol like
        const likeBtn = document.getElementById('likeButton');
        if (likes[currentIndex]) {
            likeBtn.classList.remove('btn-outline-primary');
            likeBtn.classList.add('btn-primary');
            likeBtn.textContent = 'Liked';
        } else {
            likeBtn.classList.remove('btn-primary');
            likeBtn.classList.add('btn-outline-primary');
            likeBtn.textContent = 'Like Produk Ini';
        }
    });

    document.getElementById('likeButton').addEventListener('click', function () {
        likes[currentIndex] = !likes[currentIndex];
        if (likes[currentIndex]) {
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');
            this.textContent = 'Liked';
        } else {
            this.classList.remove('btn-primary');
            this.classList.add('btn-outline-primary');
            this.textContent = 'Like Produk Ini';
        }
    });

    // Hitung Precision saat submit
    document.getElementById('feedback-form').addEventListener('submit', function (e) {
        const total = likes.length;
        const relevant = likes.filter(v => v).length;
        const precision = total > 0 ? relevant / total : 0;
        document.getElementById('precision-input').value = precision.toFixed(3);
    });
</script>

@endsection
