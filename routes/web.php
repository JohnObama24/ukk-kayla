<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

// AUTH
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::post('/login', function() { return redirect('/shop'); });
Route::get('/register', function() { return view('auth.register'); })->name('register');
Route::post('/register', function() { return redirect('/login'); });
Route::post('/logout', function() { return redirect('/'); });

Route::get('/', function () {
    return view('welcome');
});

// ============================================
// HALAMAN SHOP (DENGAN SEARCH & FILTER)
// ============================================
Route::get('/shop', function() {
    $query = Product::query();
    
    // SEARCH
    if(request('search')) {
        $query->where('name', 'like', '%' . request('search') . '%');
    }
    
    // FILTER BRAND
    if(request('brand')) {
        $query->where('brand', request('brand'));
    }
    
    $products = $query->get();
    $brands = Product::select('brand')->distinct()->get();
    
    return view('shop', compact('products', 'brands'));
});
// DETAIL PRODUK
Route::get('/product/{id}', function($id) {
    $product = Product::find($id);
    if(!$product) return abort(404);
    return view('detail', compact('product'));
});

// KERANJANG
Route::get('/cart/add/{id}', function($id) {
    $product = Product::find($id);
    $cart = session()->get('cart', []);
    $cart[] = ['id' => $id, 'name' => $product->name, 'price' => $product->price, 'qty' => 1];
    session()->put('cart', $cart);
    return redirect('/cart');
});

Route::get('/cart', function() {
    $cart = session()->get('cart', []);
    $total = 0;
    foreach($cart as $item) $total += $item['price'] * $item['qty'];
    return view('cart', compact('cart', 'total'));
});

Route::get('/cart/remove/{index}', function($index) {
    $cart = session()->get('cart', []);
    unset($cart[$index]);
    session()->put('cart', array_values($cart));
    return redirect('/cart');
});

Route::post('/cart/update/{index}', function($index) {
    $cart = session()->get('cart', []);
    if(isset($cart[$index])) $cart[$index]['qty'] = request('qty', 1);
    session()->put('cart', $cart);
    return redirect('/cart');
});

// CHECKOUT
Route::get('/checkout', function() {
    $cart = session()->get('cart', []);
    if(empty($cart)) return redirect('/shop');
    $total = 0;
    foreach($cart as $item) $total += $item['price'] * $item['qty'];
    return view('checkout-form', compact('cart', 'total'));
});

Route::post('/checkout/process', function() {
    $cart = session()->get('cart', []);
    if(empty($cart)) return redirect('/shop');
    
    $name = request('name');
    $email = request('email');
    $address = request('address');
    $phone = request('phone');
    
    $total = 0;
    $items = [];
    foreach($cart as $item) {
        $total += $item['price'] * $item['qty'];
        $items[] = $item['name'] . ' x' . $item['qty'];
    }
    
    DB::table('orders')->insert([
        'name' => $name, 'email' => $email, 'address' => $address,
        'phone' => $phone, 'total_price' => $total,
        'items' => implode('; ', $items), 'created_at' => now()
    ]);
    
    session()->forget('cart');
    return redirect('/checkout/success');
});

Route::get('/checkout/success', function() { return view('checkout-success'); });

// RIWAYAT
Route::get('/riwayat', function() {
    $orders = DB::table('orders')->orderBy('created_at', 'desc')->get();
    return view('riwayat', compact('orders'));
});

Route::get('/order/{id}', function($id) {
    $order = DB::table('orders')->where('id', $id)->first();
    if(!$order) return abort(404);
    return view('order-detail', compact('order'));
});

Route::get('/test', function() { return "Server OK - " . date('H:i:s'); 
});