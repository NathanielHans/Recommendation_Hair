@extends('layout.main')

@section("contents")
<main class="main">
    <section id="product" class="about section">
        <div class="container">
            <div class="row justify-content-center mb-1">
                <div class="col-md-6 mt-5">
                    <form action="/search" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produk..." name="search">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                @foreach($products as $product)
                <div class="my-3 justify-content-center col-sm-6 col-md-3 col-lg-3">
                    <div class="card p-2 justify-content-center product-card" data-bs-toggle="modal" data-bs-target="#productModal"
                         data-name="{{ $product['name'] }}" data-ingridients="{{ $product['ingredients'] ?? 'Tidak ada Ingredients' }}" 
                         data-price="Rp.{{ number_format((int) str_replace(['Rp ', '.'], '', $product['price']), 0, ',', '.') }}" data-link={{ $product['link'] }}>
                        <div style="text-align:left" class="deskripsi card-body">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            {{-- <p class="card-text">{{ $product['Ingredients'] ?? 'Tidak ada deskripsi' }}</p> --}}
                            <p class="card-text2">
                                Rp. 
                                {{ 
                                    isset($product['price']) && $product['price'] !== '' 
                                    ? number_format(
                                        (int) str_replace(['Rp', '.'], '', $product['price']),
                                        0, ',', '.'
                                      ) 
                                    : 'N/A' 
                                }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>  
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination.custom') }}
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
                            <p id="modalProductLink" class="fw-bold"></p>
                            <button id="btnRecommend" class="btn btn-success">Cari Rekomendasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productCards = document.querySelectorAll(".product-card");
        const btnRecommend = document.getElementById("btnRecommend");
        let selectedProductName = '';

        productCards.forEach(card => {
            card.addEventListener("click", function () {
                selectedProductName = this.getAttribute("data-name");
                document.getElementById("modalProductName").textContent = selectedProductName;
                document.getElementById("modalProductIngridients").textContent = this.getAttribute("data-ingridients");
                document.getElementById("modalProductPrice").textContent = this.getAttribute("data-price");
                const link = this.getAttribute("data-link");
                console.log(link);
                
                document.getElementById("modalProductLink").innerHTML = `<a href="${link}" target="_blank" class="text-decoration-underline text-primary">Lihat Produk</a>`;
            });
        });

        btnRecommend.addEventListener("click", function () {
            // Redirect ke halaman rekomendasi dengan query parameter product_name
            if (selectedProductName) {
                const url = new URL(window.location.origin + '/recommendation');
                url.searchParams.set('product_name', selectedProductName);
                window.location.href = url.toString();
            }
        });
    });
</script>
@endsection
