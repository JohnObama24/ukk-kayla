<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->latest()->take(8)->get();
        
        return view('home', compact('categories', 'products'));
    }

    /**
     * Show the shop page.
     */
    public function shop(Request $request)
    {
        // Ambil semua produk dengan relasi kategori
        $query = Product::with('category');

        // Filter berdasarkan kategori (jika ada)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Pencarian berdasarkan nama (jika ada)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil data dengan pagination
        $products = $query->paginate(12);
        
        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Kirim ke view
        return view('shop', compact('products', 'categories'));
    }
}