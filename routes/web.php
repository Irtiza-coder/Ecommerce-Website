<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Signup;
use App\Models\HomeContent;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testmonials;
use App\Models\Order;
use Illuminate\Http\Request;

Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

Route::get('/logout', function () {
    session()->forget(['user_id', 'user_name']);
    return redirect('/account')->with('message', 'Logged out successfully.');
})->name('logout');

Route::middleware(['checklogin'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('order.place');
    Route::get('/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('/stripe/cancel', [CheckoutController::class, 'stripeCancel'])->name('stripe.cancel');
    Route::get('/dashboard', function () {
        $user = Signup::find(session('user_id'));
        $orders = Order::with('items')->where('user_id', session('user_id'))->latest()->get();
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_amount');
        return view('dashboard', compact('user', 'orders', 'totalOrders', 'totalSpent'));
    })->name('dashboard');
    Route::get('/profile', [SignupController::class, 'showProfile'])->name('user.profile');
    Route::post('/profile/update', [SignupController::class, 'updateProfile'])->name('user.profile.update');
});


Route::middleware(['redirectuser'])->group(function () {
    Route::get('/account', fn() => view('account'))->name('account');
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup');
    Route::post('/login', [SignupController::class, 'login'])->name('login');
});



Route::get('/', function () {
    $cms = HomeContent::all()->keyBy('section');
    $categories = Category::with('products')->get();
    $testimonials = Testmonials::where('status', 1)->latest()->get();
    $featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
    if ($featuredProducts->count() < 4) {
        $featuredProducts = Product::latest()->take(8)->get();
    }
    $collectionProducts = $featuredProducts;
    $shopProducts = Product::latest()->take(8)->get();

    return view('index', compact('cms', 'categories', 'testimonials', 'collectionProducts', 'featuredProducts', 'shopProducts'));
});

Route::get('/shop', function (Request $request) {
    $cms = HomeContent::where('section', 'LIKE', 'shop_%')->get()->keyBy('section');
    $categories = Category::all();
    $query = Product::query();

    $selectedCategories = (array) $request->input('category', []);
    if (!empty(array_filter($selectedCategories))) {
        $query->whereIn('category_id', $selectedCategories);
    }

    $selectedPrices = (array) $request->input('price', []);
    if (!empty(array_filter($selectedPrices))) {
        $query->where(function ($q) use ($selectedPrices) {
            foreach ($selectedPrices as $range) {
                if ($range === '200+') {
                    $q->orWhere('price', '>=', 200);
                } else {
                    [$min, $max] = explode('-', $range);
                    $q->orWhereBetween('price', [(float) $min, (float) $max]);
                }
            }

        });
    }

    $products = $query->latest()->paginate(9)->withQueryString();

    return view('shop', compact('categories', 'products', 'cms'));
})->name('shop');


Route::get('/detail/{product:slug}', function (Product $product) {
    $similar = Product::where('id', '!=', $product->id)
        ->inRandomOrder()
        ->take(4)
        ->get();
    return view('detail', compact('product', 'similar'));
})->name('detail');



Route::get('/about-us', function () {
    $testimonials = Testmonials::where('status', 1)->latest()->get();
    $cms = HomeContent::where('section', 'LIKE', 'about_%')
        ->orWhere('section', 'testimonials')
        ->get()
        ->keyBy('section');
    return view('about-us', compact('cms', 'testimonials'));
});

Route::get('/collections', function () {
    $cms = HomeContent::where('section', 'LIKE', 'coll_%')->get()->keyBy('section');
    $collectionProducts = Product::where('is_featured', true)->latest()->take(8)->get();
    if ($collectionProducts->count() < 4) {
        $collectionProducts = Product::latest()->take(8)->get();
    }
    return view('collections', compact('collectionProducts', 'cms'));
});
Route::get('/contact-us', function () {
    $cms = HomeContent::where('section', 'LIKE', 'contact_%')->get()->keyBy('section');
    return view('contact-us', compact('cms'));
});
// Route::get('/cart', fn() => view('cart'));

Route::get('/journal', function () {
    $cms = HomeContent::where('section', 'LIKE', 'journal_%')->get()->keyBy('section');
    return view('journal', compact('cms'));
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->middleware('redirectifadmin')->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['checkadmin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

        // Customers Management
        Route::get('/customers', [AdminController::class, 'customersIndex'])->name('admin.customers.index');
        Route::get('/customers/{customer}', [AdminController::class, 'customerShow'])->name('admin.customers.show');

        // Contact Inquiries Inbox
        Route::get('/contacts', [AdminController::class, 'contactsIndex'])->name('admin.contacts.index');
        Route::delete('/contacts/{contact}', [AdminController::class, 'contactDestroy'])->name('admin.contacts.destroy');

        // CMS Homepage Content
        Route::get('/homepage', [AdminController::class, 'homepageIndex'])->name('admin.homepage.index');
        Route::get('/homepage/{section}/edit', [AdminController::class, 'editSection'])->name('admin.homepage.edit');
        Route::post('/homepage/{section}', [AdminController::class, 'updateSection'])->name('admin.homepage.update');

        // CMS Collections Content
        Route::get('/collections', [AdminController::class, 'collectionsIndex'])->name('admin.collections.index');
        Route::get('/collections/{section}/edit', [AdminController::class, 'editCollectionSection'])->name('admin.collections.edit');
        Route::post('/collections/{section}', [AdminController::class, 'updateCollectionSection'])->name('admin.collections.update');

        // CMS About Us Content
        Route::get('/about-us', [AdminController::class, 'about_index'])->name('admin.about-us.index');
        Route::get('/about-us/{section}/edit', [AdminController::class, 'editaboutsection'])->name('admin.about-us.edit');
        Route::post('/about-us/{section}', [AdminController::class, 'updateaboutsection'])->name('admin.about-us.update');

        // CMS Journal Content
        Route::get('/journal', [AdminController::class, 'journal_index'])->name('admin.journal.index');
        Route::get('/journal/{section}/edit', [AdminController::class, 'editjournalsection'])->name('admin.journal.edit');
        Route::post('/journal/{section}', [AdminController::class, 'updatejournalsection'])->name('admin.journal.update');

        // CMS Shop Content
        Route::get('/shop', [AdminController::class, 'shop_index'])->name('admin.shop.index');
        Route::get('/shop/{section}/edit', [AdminController::class, 'editShopSection'])->name('admin.shop.edit');
        Route::post('/shop/{section}', [AdminController::class, 'updateShopSection'])->name('admin.shop.update');

        // CMS Contact Us Content
        Route::get('/contact-cms', [AdminController::class, 'contact_index'])->name('admin.contact-cms.index');
        Route::get('/contact-cms/{section}/edit', [AdminController::class, 'editContactSection'])->name('admin.contact-cms.edit');
        Route::post('/contact-cms/{section}', [AdminController::class, 'updateContactSection'])->name('admin.contact-cms.update');

        // CRUD
        Route::resource('/products', ProductController::class)->names('admin.products');
        Route::resource('/testimonials', TestimonialsController::class)->names('admin.testimonials');
        Route::resource('/categories', CategoryController::class)->names('admin.categories');
        Route::resource('/orders', OrderController::class)->only(['index', 'show', 'update', 'destroy'])->names('admin.orders');
    });
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Wishlist Routes
Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{id}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove/{id}', [\App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');