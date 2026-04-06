<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

// HANYA 1 ROUTE UNTUK TEST
Route::get('/', function () {
    // Ambil data langsung di sini
    $products = Product::with('category')->get();
    $categories = Category::all();

    // Tampilkan view test
    return view('test', compact('products', 'categories'));
});