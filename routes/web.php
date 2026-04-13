<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\AdminMiddleware;

// AUTH
Route::get('/login', function() { 
    if(Auth::check()) return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/shop');
    return view('auth.login'); 
})->name('login');

Route::post('/login', function(Request $request) { 
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if(Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/shop');
    }

    return back()->withErrors([
        'email' => 'Kredensial tidak cocok dengan data kami.',
    ]);
});

Route::get('/register', function() { 
    if(Auth::check()) return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/shop');
    return view('auth.register'); 
})->name('register');

Route::post('/register', function(Request $request) { 
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8', // Fixed min length from 1 to 8 usually but let's not enforce too strict yet, 8 is okay.
    ]);
    
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
    ]);
    
    Auth::login($user);
    return redirect('/shop');
});

Route::post('/logout', function(Request $request) { 
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');


// PANDUAN DAN HOME
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
    // Retrieve ALL distinct brands regardless of search status
    $brands = Product::select('brand')->distinct()->whereNotNull('brand')->pluck('brand');
    
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
    
    // Check if item already in cart
    $found = false;
    foreach($cart as &$item) {
        if($item['id'] == $id) {
            $item['qty'] += 1;
            $found = true;
            break;
        }
    }
    if(!$found) {
        $cart[] = ['id' => $id, 'name' => $product->name, 'price' => $product->price, 'qty' => 1];
    }
    
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
    if(isset($cart[$index])) {
        $qty = request('qty', 1);
        if($qty > 0) {
            $cart[$index]['qty'] = $qty;
        } else {
            unset($cart[$index]);
        }
    }
    session()->put('cart', array_values($cart));
    return redirect('/cart');
});

// CHECKOUT (Harus Login)
Route::middleware(['auth'])->group(function() {
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
        $phone = request('phone') ?: '-';
        
        $total = 0;
        $items = [];
        foreach($cart as $item) {
            $total += $item['price'] * $item['qty'];
            $items[] = $item['name'] . ' x' . $item['qty'];
        }
        
      DB::table('orders')->insert([
    'user_id' => Auth::id(),
    'name' => $name, 
    'email' => $email, 
    'address' => $address,
    'phone' => $phone, 
    'total_price' => $total,
    'items' => implode('; ', $items),

    'payment_method' =>  request('payment_method'),

    'created_at' => now()
]);
        session()->forget('cart');
        return redirect('/checkout/success');
    });

    Route::get('/checkout/success', function() { return view('checkout-success'); });

    // RIWAYAT
    Route::get('/riwayat', function() {
        $orders = DB::table('orders')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('riwayat', compact('orders'));
    })->name('riwayat');

    Route::get('/order/{id}', function($id) {
        $order = DB::table('orders')->where('id', $id)->where('user_id', Auth::id())->first();
        if(!$order) return abort(404);
        return view('order-detail', compact('order'));
    });
});

// AMAN ADMIN ROUTES
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function() {
    
    // DASHBOARD
    Route::get('/dashboard', function() {
        $products = Product::all();
        $orders = DB::table('orders')->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.dashboard', compact('products', 'orders'));
    })->name('admin.dashboard');

    // CREATE
    Route::post('/product/store', function(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);
        
        if($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = '/images/products/' . $imageName;
        }

        Product::create($validated);
        return back()->with('success', 'Produk berhasil ditambahkan.');
    });

    // UPDATE
    Route::post('/product/update/{id}', function(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);
        
        if($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = '/images/products/' . $imageName;
        }

        $product = Product::findOrFail($id);
        $product->update($validated);
        return back()->with('success', 'Produk berhasil diperbarui.');
    });

    // DELETE
    Route::post('/product/delete/{id}', function($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    });
});

Route::get('/test', function() { return "Server OK - " . date('H:i:s'); });