<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function index (){
        $response = Http::get('http://127.0.0.1:5000/get_products');
        if ($response->successful()) {
            $products = $response->json(); // Ubah JSON ke array PHP
            // dd($products); // Dump & Die untuk melihat hasilnya
            // dd(count($products));
            // dd($products);
            $brands = collect($products)->pluck('Brand')->unique();
            // dd($brands);
            return view('recommendation', compact('products', 'brands'));
        } else {
            // dd("Error: " . $response->status());
            return redirect()->back()->with('error', $response->json()['error'] ?? 'Gagal mengambil rekomendasi.');
        }
    }

    public function getRecommendations(Request $request)
    {
        $productName = $request->input('product_name');
        $hairType = $request->input('hair_type');
        $brand = $request->input('brandSelect');
        $recommendations = [];
        try {
            if (!empty($productName)) {
                // Kirim request ke Flask route berdasarkan produk
                $response = Http::get("http://127.0.0.1:5000/recommend_by_product", [
                    'product_name' => $productName,
                    'hair_type' => $hairType
                ]);
            }elseif ($hairType !== null && $hairType !== '')  {
                // Kirim request ke Flask route berdasarkan jenis rambut
                $response = Http::get("http://127.0.0.1:5000/recommend_by_hair_type", [
                    'hair_type' => $hairType,
                    'brand' => $brand
                ]);
                // dd($response);
            } else {
                // dd($request);

                return redirect()->back()->with('error', 'Silakan pilih produk atau jenis rambut.');
            }

            if ($response->successful()) {
                $recommendations = $response->json()['recommendations'];
            } else {
                // dd($response->body());
                return redirect()->back()->with('error', $response->json()['error'] ?? 'Tidak ada Rekomendasi untuk produk yang diinginkan.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        // dd($recommendations);
        return view('hasil', compact('recommendations'));
    }

}