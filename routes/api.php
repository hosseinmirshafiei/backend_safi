<?php


use App\Http\Controllers\Admin\AdminInfo\AdminInfoController;
use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\Admin\Biography\BiographyController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Category\CategoryBrandsController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Color\ColorController;
use App\Http\Controllers\Admin\Comment\CommentController;
use App\Http\Controllers\Admin\Delivery\DeliveryController;
use App\Http\Controllers\Admin\Discount\GeneralDiscountController;
use App\Http\Controllers\Admin\Discount\ProductDiscountController;
use App\Http\Controllers\Admin\Gallery\GalleryController;
use App\Http\Controllers\Admin\Order\OrderController as OrderOrderController;
use App\Http\Controllers\Admin\ProductColor\ProductColorController;
use App\Http\Controllers\Admin\Property\PropertyController;
use App\Http\Controllers\Admin\PropertyProduct\PropertyProductController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Size\SizeController;
use App\Http\Controllers\Admin\Slide\SlideController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Market\Address\AddressController;
use App\Http\Controllers\Market\Cart\CartController;
use App\Http\Controllers\Market\Comment\CommentController as CommentCommentController;
use App\Http\Controllers\Market\ContactUs\ContactUsController;
use App\Http\Controllers\Market\Home\HomeController;
use App\Http\Controllers\Market\InfoWebSite\InfoWebSiteController;
use App\Http\Controllers\Market\LoginRegister\LoginRegisterController;
use App\Http\Controllers\Market\Offers\OffersController;
use App\Http\Controllers\Market\Order\OrderController;
use App\Http\Controllers\Market\Product\ProductController;
use App\Http\Controllers\Market\Profile\ProfileController;
use App\Http\Controllers\Market\Search\SearchController;
use App\Http\Controllers\Market\Shopping\ShoppingController;
use App\Http\Controllers\Market\Sitemap\SitemapController;
use App\Http\Controllers\Market\Wallet\WalletController;
use App\Http\Controllers\SanctumController;
use App\Http\Controllers\TController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::post('admin/savepush',"App\Http\Controllers\PushController@store");

// ///////

// Route::post('reg', "App\Http\Controllers\SanctumController@reg");
// Route::post('log', "App\Http\Controllers\SanctumController@log");
// Route::
// middleware('auth:sanctum')->
// get('test', "App\Http\Controllers\SanctumController@test");
///////
Route::
middleware('admin')->
prefix('admin')->namespace('Admin')->group(function () {

    Route::prefix('admin-info')->group(function () {
        Route::post('/index', [AdminInfoController::class, 'index'])->name('admin.admin-info.index');
        Route::post('/upload-image', [AdminInfoController::class, 'uploadImage'])->name('admin.admin-info.uploadImage');
        Route::post('/edit', [AdminInfoController::class, 'edit'])->name('admin.admin-info.edit');
    });

    Route::prefix('category')->group(function () {
        Route::post('/index', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::post('/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');
        Route::post('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/all-category', [CategoryController::class, 'allCategory'])->name('admin.category.all-category');
        Route::post('/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::post('/upload', [CategoryController::class, 'upload'])->name('admin.category.upload');
        Route::post('/status', [CategoryController::class, 'status'])->name('admin.category.status');
    });
    Route::prefix('category-brands')->group(function () {
        Route::post('/index', [CategoryBrandsController::class, 'index'])->name('admin.category-brands.index');
        Route::post('/update', [CategoryBrandsController::class, 'update'])->name('admin.category-brands.update');
    });

    Route::prefix('property')->group(function () {
        Route::post('/index', [PropertyController::class, 'index'])->name('admin.property.index');
        Route::post('/create', [PropertyController::class, 'create'])->name('admin.property.create');
        Route::post('/delete', [PropertyController::class, 'delete'])->name('admin.property.delete');
        Route::post('/update', [PropertyController::class, 'update'])->name('admin.property.update');
    });
    Route::prefix('property-product')->group(function () {
        Route::post('/index', [PropertyProductController::class, 'index'])->name('admin.property-product.index');
        Route::post('/submit', [PropertyProductController::class, 'submit'])->name('admin.property-product.submit');
    });

    Route::prefix('product')->group(function () {
        Route::post('/index', [App\Http\Controllers\Admin\Product\ProductController::class, 'index'])->name('admin.product.index');
        Route::post('/general_discount', [App\Http\Controllers\Admin\Product\ProductController::class, 'generalDiscount'])->name('admin.product.general_discount');
        Route::post('/delete', [App\Http\Controllers\Admin\Product\ProductController::class, 'delete'])->name('admin.product.delete');
        Route::post('/ckeditor', [App\Http\Controllers\Admin\Product\ProductController::class, 'ckeditor'])->name('admin.product.ckeditor');
        Route::post('/upload-image', [App\Http\Controllers\Admin\Product\ProductController::class, 'uploadImage'])->name('admin.product.uploadimage');
        Route::post('/create', [App\Http\Controllers\Admin\Product\ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [App\Http\Controllers\Admin\Product\ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/edit', [App\Http\Controllers\Admin\Product\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/update', [App\Http\Controllers\Admin\Product\ProductController::class, 'update'])->name('admin.product.update');
    });
    Route::prefix('gallery')->group(function () {
        Route::post('/index', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::post('/upload-image', [GalleryController::class, 'uploadImage'])->name('admin.gallery.upload-image');
        Route::post('/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
    });
    Route::prefix('brand')->group(function () {
        Route::post('/index',  [BrandController::class, 'index'])->name('admin.brand.index');
        Route::post('/edit',   [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::post('/create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/delete', [BrandController::class, 'delete'])->name('admin.brand.delete');
        Route::post('/update', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::post('/upload-image', [BrandController::class, 'uploadImage'])->name('admin.brand.uploadimage');
    });
    Route::prefix('delivery')->group(function () {
        Route::post('/index', [DeliveryController::class, 'index'])->name('admin.delivery.index');
        Route::post('/create', [DeliveryController::class, 'create'])->name('admin.delivery.create');
        Route::post('/status', [DeliveryController::class, 'status'])->name('admin.delivery.status');
    });
    Route::prefix('general-discount')->group(function () {
        Route::post('/index', [GeneralDiscountController::class, 'index'])->name('admin.general-discount.index');
        Route::post('/create', [GeneralDiscountController::class, 'create'])->name('admin.general-discount.create');
        Route::post('/status', [GeneralDiscountController::class, 'status'])->name('admin.general-discount.status');
    });
    Route::prefix('product-discount')->group(function () {
        Route::post('/index', [ProductDiscountController::class, 'index'])->name('admin.product-discount.index');
        Route::post('/show', [ProductDiscountController::class, 'show'])->name('admin.product-discount.show');
        Route::post('/create', [ProductDiscountController::class, 'create'])->name('admin.product-discount.create');
        Route::post('/status', [ProductDiscountController::class, 'status'])->name('admin.product-discount.status');
    });
    Route::prefix('comment')->group(function () {
        Route::post('/index', [CommentController::class, 'index'])->name('admin.comment.index');
        Route::post('/status', [CommentController::class, 'status'])->name('admin.comment.status');
        Route::post('/show', [CommentController::class, 'show'])->name('admin.comment.show');
        Route::post('/create', [CommentController::class, 'create'])->name('admin.comment.create');
    });
    Route::prefix('attribute')->group(function () {
        Route::post('/index', [AttributeController::class, 'index'])->name('admin.attribute.index');
        Route::post('/create', [AttributeController::class, 'create'])->name('admin.attribute.create');
    });
    Route::prefix('slide')->group(function () {
        Route::post('/index', [SlideController::class, 'index'])->name('admin.slide.index');
        Route::post('/upload-image', [SlideController::class, 'uploadImage'])->name('admin.slide.upload-image');
        Route::post('/create', [SlideController::class, 'create'])->name('admin.slide.create');
    });
    Route::prefix('settings')->group(function () {
        Route::post('/index', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/create', [SettingController::class, 'create'])->name('admin.settings.create');
        Route::post('/upload', [SettingController::class, 'upload'])->name('admin.settings.upload');
    });
    Route::prefix('colors')->group(function () {
        Route::post('/index', [ColorController::class, 'index'])->name('admin.colors.index');
        Route::post('/create', [ColorController::class, 'create'])->name('admin.colors.create');
        Route::post('/edit', [ColorController::class, 'edit'])->name('admin.colors.edit');
        Route::post('/update', [ColorController::class, 'update'])->name('admin.colors.update');
    });
    Route::prefix('size')->group(function () {
        Route::post('/index', [SizeController::class, 'index'])->name('admin.size.index');
        Route::post('/create', [SizeController::class, 'create'])->name('admin.size.create');
        Route::post('/update', [SizeController::class, 'update'])->name('admin.size.update');
        Route::post('/update-type-size', [SizeController::class, 'updateTypeSize'])->name('admin.size.updateTypeSize');
        Route::post('/create-type-size', [SizeController::class, 'createTypeSize'])->name('admin.size.createTypeSize');
    });
    Route::prefix('color-product')->group(function () {
        Route::post('/index', [ProductColorController::class, 'index'])->name('admin.productColor.index');
        Route::post('/update', [ProductColorController::class, 'update'])->name('admin.productColor.update');
    });
    Route::prefix('users')->group(function () {
        Route::post('/index', [UsersController::class, 'index'])->name('admin.users.index');
    });
    Route::prefix('orders')->group(function () {
        Route::post('/index', [OrderOrderController::class, 'index'])->name('admin.orders.index');
        Route::post('/checked', [OrderOrderController::class, 'checked'])->name('admin.orders.checked');
        Route::post('/orders-user', [OrderOrderController::class, 'ordersUser'])->name('admin.orders.ordersUser');
    });

    Route::prefix('biography')->group(function () {
        Route::post('/edit', [BiographyController::class, 'edit'])->name('admin.biography.edit');
        Route::post('/update', [BiographyController::class, 'update'])->name('admin.biography.update');
    });

});

///////////////////////////////////////

Route::prefix('market')->namespace('Market')->group(function () {
    Route::prefix('info-website')->group(function () {
        Route::post('/index', [InfoWebSiteController::class, 'index'])->name('menu.index');
    });
    Route::prefix('home')->group(function () {
        Route::post('/index', [HomeController::class, 'index'])->name('market.home.index');
    });
    Route::prefix('search')->group(function () {
        Route::post('/products', [SearchController::class, 'searchProducts'])->name('market.search.products');
    });
    Route::prefix('product')->group(function () {
        Route::post('/index', [ProductController::class, 'index'])->name('market.product.index');
        Route::post('/show', [ProductController::class, 'show'])->name('market.product.show');
    });
    Route::prefix('offers-products')->group(function () {
        Route::post('/index', [OffersController::class, 'index'])->name('market.offers-products.index');
    });
    Route::prefix('cart')->group(function () {
        Route::post('/index', [CartController::class, 'index'])->name('market.cart.index');
        Route::post('/create', [CartController::class, 'create'])->name('market.cart.create');
        Route::middleware('cartSubmit')->post('/submit', [CartController::class, 'submit'])->name('market.cart.submit');
        Route::post('/delete', [CartController::class, 'delete'])->name('market.cart.delete');
    });
    Route::prefix('login-register')->group(function () {
        Route::post('/login-register',   [LoginRegisterController::class, 'loginRegister'])->name('market.loginRegister');
        Route::post('/login-confirm', [LoginRegisterController::class, 'loginConfirm'])->name('market.loginConfirm');
        Route::post('/login-resend-otp', [LoginRegisterController::class, 'loginResendOtp'])->name('market.login-resend-otp');
        Route::middleware('isLogin')->post('/logout', [LoginRegisterController::class, 'logout'])->name('market.logout');
    });
    Route::prefix('shopping')->group(function () {
        Route::middleware('shopp')->post('/index', [ShoppingController::class, 'index'])->name('market.shopping.index');
        Route::middleware('shoppSubmit')->post('/submit', [ShoppingController::class, 'submit'])->name('market.shopping.submit');
    });
    Route::middleware('isLogin')->prefix('address')->group(function () {
        Route::post('/create', [AddressController::class, 'create'])->name('market.address.create');
        Route::post('/update', [AddressController::class, 'update'])->name('market.address.update');
        Route::post('/switch', [AddressController::class, 'switch'])->name('market.address.switch');
    });
    Route::prefix('orders')->group(function () {
        Route::middleware('orders')->post('/index', [OrderController::class, 'index'])->name('market.orders.index');
        Route::middleware('orderPayment')->post('/payment', [OrderController::class, 'payment'])->name('market.orders.payment');
    });
    Route::middleware('isLogin')->prefix('wallet')->group(function () {
        Route::post('/charge', [WalletController::class, 'charge'])->name('market.wallet.charge');
        Route::post('/wallet-state', [WalletController::class, 'walletState'])->name('market.wallet.walletState');
        Route::post('/wallet-state-order', [WalletController::class, 'walletStateOrder'])->name('market.wallet.walletStateOrder');
    });
    Route::middleware('isLogin')->prefix('comment')->group(function () {
        Route::post('/create', [CommentCommentController::class, 'create'])->name('market.comment.create');
        Route::post('/load-more', [CommentCommentController::class, 'loadMore'])->name('market.comment.loadMore');
    });
    Route::middleware('isLogin')->prefix('profile')->group(function () {
        Route::post('/index', [ProfileController::class, 'index'])->name('market.profile.index');
        Route::post('/edit', [ProfileController::class, 'edit'])->name('market.profile.edit');
        Route::post('/upload-image', [ProfileController::class, 'uploadImage'])->name('market.profile.uploadImage');
    });
    Route::prefix('biography')->group(function () {
        Route::post('/index', [App\Http\Controllers\Market\Biography\BiographyController::class, 'index'])->name('market.biography.index');
    });
    Route::prefix('contact-us')->group(function () {
        Route::post('/index', [ContactUsController::class, 'index'])->name('market.contact.index');
    });
    Route::prefix('sitemap')->group(function () {
        Route::get('/products', [SitemapController::class, 'products'])->name('market.sitemap.products');
    });
});
