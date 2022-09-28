<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SlideImageController;
use App\Http\Controllers\BillController;;
use App\Http\Controllers\Reports\SaleReportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    // Auth::logout();
    return view('auth.login');
});

Route::get('/test', function () {
    // Auth::logout();
    return view('test');
});

Auth::routes();

/* -------------------------- User Routes - START -------------------------- */
Route::group(['prefix' => 'user', 'middleware' => [ 'isUser']], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/unit/create', [UserController::class, 'create'])->name('unit.create');
    Route::get('/unit/index', [UserController::class, 'unitIndex'])->name('unit.index');
    Route::post('/unit/store', [UserController::class, 'store'])->name('unit.store');
    Route::get('/unit/edit/{id}', [UserController::class, 'unitEdit'])->name('unit.edit');
    Route::post('/unit/update/{id}', [UserController::class, 'update'])->name('unit.update');

    Route::post('/unit/data', [App\Http\Controllers\UserController::class, 'getAllUnits'])->name('unit.data');
    Route::post('/category/data', [App\Http\Controllers\UserController::class, 'getAllCategory'])->name('category.data');
    Route::post('/subcategory/data', [App\Http\Controllers\UserController::class, 'getAllSubcategory'])->name('subcategory.data');
    Route::post('/maincategory/data', [App\Http\Controllers\UserController::class, 'getAllMainCategory'])->name('maincategory.data');
    Route::post('/supplier/data',[UserController::class, 'getAllSupplier'])->name('supplier.data');
    Route::post('/bill/data',[UserController::class, 'getAllBill'])->name('bill.data');


    // Route::get('/category/delete/{id}', [UserController::class, 'delete'])->name('category.delete');
    // Route::get('/subcategory/delete/{id}', [UserController::class, 'remove'])->name('subcategory.remove');
    // Route::get('/unit/delete/{id}', [UserController::class, 'deleteUnit'])->name('unit.deleteUnit');
    Route::post('/product/data', [UserController::class, 'getAllProduct'])->name('product.data');
    Route::post('/product/data1', [UserController::class, 'allProducts'])->name('products.data');
    // Route::get('/product/delete/{id}', [UserController::class, 'deletion'])->name('product.deletion');
    Route::get('/product/create/{id}', [ProductsController::class, 'createProduct'])->name('product.create1');
    Route::get('/product/mainindex', [UserController::class, 'mainIndex'])->name('product.mainindex');
    Route::get('/product/print/{id}', [UserController::class, 'printProduct'])->name('product.print');



    // Route::get('/maincategory/delete/{id}', [UserController::class, 'deleting'])->name('maincategory.deleting');
    // Route::get('/supplier/delete', [UserController::class, 'deletesupplier'])->name('supplier.deletesupplier');
    // Route::get('/bill/delete', [UserController::class, 'deleteBill'])->name('bill.deleteBill');
    Route::get('/bill/{id}', [UserController::class, 'goToBillPage'])->name('navigate.bill');
    Route::get('/product/{id}', [UserController::class, 'goToProductPage'])->name('navigate.product');
    Route::post('/bill/supid', [BillController::class, 'updateBill'])->name('update.bill');
    
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubcategoryController::class);
    Route::resource('maincategory', MainCategoryController::class);
    Route::resource('product', ProductsController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('bill', BillController::class);

});

/* -------------------------- Manager Routes - START -------------------------- */
Route::group(['prefix' => 'manager', 'middleware' => [ 'isManager']], function () {
    Route::get('/', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/order', [ManagerController::class, 'orderIndex'])->name('manager.order.index');
    Route::post('/order/data', [App\Http\Controllers\ManagerController::class, 'getAllOrder'])->name('order.data');
    Route::post('/order/show', [App\Http\Controllers\ManagerController::class, 'showAllOrder'])->name('order.show.data');

    // Route::get('/order/delete/{id}', [ManagerController::class, 'deleteOrder'])->name('manager.order.delete');
    // Route::post('/order/show', [App\Http\Controllers\ManagerController::class, 'showAllOrder'])->name('order.show.data');
    Route::get('/order/info/{id}', [ManagerController::class, 'show'])->name('manager.order.show');
    Route::get('/order/confirmed/{id}', [ManagerController::class, 'confirmOrder'])->name('order.confirm');
    Route::get('/order/cancelled/{id}', [ManagerController::class, 'cancelOrder'])->name('order.cancel');

    Route::get('/order/pending', [ManagerController::class, 'orderPending'])->name('order.pending');
    Route::post('/order/pending-data', [App\Http\Controllers\ManagerController::class, 'getPending'])->name('pending.data');

    Route::get('/order/confirmed', [ManagerController::class, 'orderApproved'])->name('order.approved');
    Route::post('/order/approved-data', [App\Http\Controllers\ManagerController::class, 'getApproved'])->name('approved.data');

    Route::get('/order/cancelled', [ManagerController::class, 'orderCancelled'])->name('order.cancelled');
    Route::post('/order/cancelled-data', [App\Http\Controllers\ManagerController::class, 'getCancelled'])->name('cancelled.data');

    Route::get('/productIndex', [ManagerController::class, 'productIndex'])->name('product.Index');
    Route::post('/manager/products', [ManagerController::class, 'Products'])->name('manager.products.data');

});


/* -------------------------- Admin Routes - START -------------------------- */
Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/user/index', [AdminController::class, 'userIndex'])->name('admin.user.index');
    Route::get('/user/create', [AdminController::class, 'createUser'])->name('admin.user.create');
    Route::post('/user/store', [AdminController::class, 'store'])->name('admin.user.store');
    Route::get('/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::post('/user/update/{id}', [AdminController::class, 'userUpdate'])->name('user.update');
    Route::get('/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::post('/user/data', [App\Http\Controllers\AdminController::class, 'getAllUsers'])->name('admin.user.data');

    Route::get('/manager/index', [AdminController::class, 'managerIndex'])->name('admin.manager.index');
    Route::get('/manager/create', [AdminController::class, 'createManager'])->name('admin.manager.create');
    Route::post('/manager/store', [AdminController::class, 'managerStore'])->name('admin.manager.store');
    Route::get('/manager/edit/{id}', [AdminController::class, 'editManager'])->name('admin.manager.edit');
    Route::post('/manager/update/{id}', [AdminController::class, 'managerUpdate'])->name('manager.update');
    Route::get('/manager/delete/{id}', [AdminController::class, 'deleteManager'])->name('admin.manager.delete');
    Route::post('/manager/data', [App\Http\Controllers\AdminController::class, 'getAllManager'])->name('manager.data');
    Route::post('/payment/data',[App\Http\Controllers\AdminController::class, 'getAllPayRequest'])->name('payment.data');

    Route::get('/payment/info/{id}', [AdminController::class, 'show'])->name('admin.payment.show');
    Route::get('/payment/confirmed/{id}', [AdminController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/payment/reject/{id}', [AdminController::class, 'rejectPayment'])->name('payment.reject');

    Route::get('/payment/pending', [AdminController::class, 'paymentPending'])->name('payment.pending');
    Route::post('/payment/pending-data', [App\Http\Controllers\AdminController::class, 'getPending'])->name('pending.data');

    Route::get('/payment/approved', [AdminController::class, 'paymentApproved'])->name('payment.approved');
    Route::post('/payment/approved-data', [App\Http\Controllers\AdminController::class, 'getApproved'])->name('approved.data');

    Route::get('/payment/cancelled', [AdminController::class, 'paymentCancelled'])->name('payment.cancelled');
    Route::post('/payment/cancelled-data', [App\Http\Controllers\AdminController::class, 'getCancelled'])->name('cancelled.data');

    Route::get('/payment/index', [AdminController::class, 'paymentIndex'])->name('admin.payment.index');

    Route::get('/payment/info/{id}', [AdminController::class, 'show'])->name('admin.payment.show');

    Route::post('/admin/sales-report', [App\Http\Controllers\AdminController::class,'getAllSale'])->name('sales.data');
    Route::post('/admin/member-report', [App\Http\Controllers\AdminController::class,'getAllMember'])->name('member.reports');
    Route::post('/admin/purchase-report',[App\Http\Controllers\AdminController::class,'getAllPurchase'])->name('purchase.data');
    Route::post('/admin/stock-report', [App\Http\Controllers\AdminController::class, 'getAllStock'])->name('stock.data');
    Route::post('/admin/top10-report', [App\Http\Controllers\AdminController::class, 'getAllTop'])->name('top.data');
    Route::post('/admin/daybook-report', [App\Http\Controllers\AdminController::class, 'getAllDay'])->name('daybook.data');
    Route::post('/admin/order-report', [App\Http\Controllers\AdminController::class, 'getConfirmOrder'])->name('confirmorder.data');
    Route::post('/admin/supplier-report', [App\Http\Controllers\AdminController::class, 'getSuppliers'])->name('supplier1.data');
    
    Route::get('reports/sales', [SaleReportController::class,'sale'])->name('reports.sales');
    Route::get('reports/purchase', [SaleReportController::class,'purchase'])->name('reports.purchase');
    Route::get('reports/stock', [SaleReportController::class,'stock'])->name('reports.stock');
    Route::get('reports/top10', [SaleReportController::class,'top'])->name('reports.top10');
    Route::get('reports/daybook', [SaleReportController::class,'daybook'])->name('reports.daybook');
    Route::get('reports/member', [SaleReportController::class,'member'])->name('reports.member');
    Route::get('reports/order', [SaleReportController::class, 'order'])->name('reports.order');
    Route::get('reports/supplier', [SaleReportController::class, 'supplier'])->name('reports.supplier');

    Route::resource('member', MemberController::class);
    Route::get('/member/info/{id}', [MemberController::class, 'show'])->name('manager.show');
    Route::post('/member/data', [App\Http\Controllers\MemberController::class,'getMembers'])->name('member.data');
    Route::post('/member/show', [App\Http\Controllers\MemberController::class, 'showAllMembers'])->name('member.show.data');



    Route::get('membership', [MemberController::class, 'membershipAmount'])->name('membership.amount');
    Route::get('membership-level', [MemberController::class, 'levelIndex'])->name('membership.level');
    Route::post('level/store', [MemberController::class, 'storeLevel'])->name('level.store');
    Route::get('/level/edit/{id}', [MemberController::class, 'editLevel'])->name('level.edit');
    Route::patch('/level/update/{id}', [MemberController::class, 'levelUpdate'])->name('level.update');




    Route::post('/membership/amount', [App\Http\Controllers\MemberController::class, 'getAllLevel'])->name('level.data');
    Route::post('/membership/level', [App\Http\Controllers\MemberController::class, 'getAllMembership'])->name('membership.data');

    Route::get('/membership/create', [MemberController::class, 'createMembership'])->name('membership.create');
    Route::post('membership/store', [MemberController::class, 'membershipStore'])->name('membership.store');
    Route::get('/membership/edit/{id}', [MemberController::class, 'editMembership'])->name('member.editMembership');
    Route::patch('/membership/update/{id}', [MemberController::class, 'membershipUpdate'])->name('membershipUpdate');

    Route::resource('slide', SlideImageController::class);
    Route::post('/slide/data', [App\Http\Controllers\SlideImageController::class, 'getAllSlide'])->name('slide.data');




});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
