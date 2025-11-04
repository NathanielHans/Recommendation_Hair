@extends('layout.main')

@section('contents')
    <main class="main">
        <section id="recommendation" class=" cover-container d-flex justify-content-center align-items-center min-vh-100">
            <div class="container">
                <h2 class="text-center section-title"><strong>Cari Rekomendasi Produk </strong></h2>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('hasilrec') }}" method="GET">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="name-tab" data-bs-toggle="tab" href="#name" role="tab"
                                aria-controls="name" aria-selected="true">Cari Berdasarkan Nama Produk</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="brand-tab" data-bs-toggle="tab" href="#brand" role="tab"
                                aria-controls="brand" aria-selected="false">Cari Berdasarkan Brand</a>
                        </li>
                    </ul>

                    <div class="card shadow-sm">

                        <div class="card-body">
                            <!-- Tab Content -->
                            <div class="tab-content" id="productTabContent">
                                <!-- Tab untuk Nama Produk -->
                                <div class="tab-pane fade show active" id="name" role="tabpanel"
                                    aria-labelledby="name-tab">
                                    <div class="my-4">


                                        <label for="product_name" class="form-label">Cari Nama Produk</label>
                                        <input class="form-control" list="products" id="product_name" name="product_name"
                                            placeholder="Cari nama produk...">

                                        <!-- Datalist untuk pilihan produk -->
                                        <datalist id="products">
                                            @foreach ($products as $product)
                                                <option value="{{ $product['Name'] }}"></option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>

                                <!-- Tab untuk Brand Produk -->
                                <div class="tab-pane fade" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                                    <div class="my-4">
                                        <label for="brand" class="form-label">Pilih Brand Produk</label>
                                        <select class="form-select" id="brandSelect" name="brandSelect">
                                            <option value="">-- Pilih Brand --</option>
                                            @foreach ($brands as $brand)
                                                <!-- Menggunakan data brand unik -->
                                                <option value="{{ $brand }}">{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilih Jenis Masalah Rambut -->
                            <div class="my-4">
                                <label for="hair_type" class="form-label">Pilih Jenis Masalah Rambut</label>
                                <select class="form-select" id="hair_type" name="hair_type">
                                    <option value="">-- Pilih --</option>
                                    <option value="1">Rontok</option>
                                    <option value="2">Berminyak</option>
                                    <option value="3">Bewarna</option>
                                    <option value="0">Kering</option>
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Cari Rekomendasi</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("SCRIPT LOADED");
        const brandSelect = document.getElementById("brandSelect");
        const hairTypeSelect = document.getElementById("hair_type");
        if (!brandSelect) {
            console.warn("Brand select element not found!");
            return;
        }
        brandSelect.addEventListener("change", function () {
            // console.log("Fetching");
            const selectedBrand = this.value;
            hairTypeSelect.innerHTML = '<option value="">-- Pilih --</option>';
            if (selectedBrand) {
                console.log("Fetching");
            
                fetch(`http://localhost:5000/get_hair_types_by_brand?brand=${encodeURIComponent(selectedBrand)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.hair_types && data.hair_types.length > 0) {
                            data.hair_types.forEach(function (item) {
                                const option = document.createElement("option");
                                option.value = item.value;
                                option.text = item.label;
                                hairTypeSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement("option");
                            option.text = "Tidak ada jenis rambut untuk brand ini";
                            option.disabled = true;
                            hairTypeSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching hair types:', error);
                    });
            }
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productName = urlParams.get('product_name');

    if (productName) {
        const productInput = document.getElementById('product_name');
        if (productInput) {
            productInput.value = productName;
        }
    }
});
</script>

@endsection
