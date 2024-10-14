<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\FlagMiddleware;
use App\Models\Flight;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Tax;
use App\Models\FinancialReport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // echo (new Flight())->getTable();
    // die;


    // $query = DB::table('users');
    // dd($query->toRawSql());


    // $find = $query->find(15);
    // dd($find);


    // $findOr = $query->findOr(15, function () {
    //     abort(404);
    // });
    // dd($findOr);


    // $names = $query->pluck('name', 'email')->all();
    // dd($names);


    // $query->orderBy('id')->chunk(100, function (Collection $users) {
    //     dd($users);

    //     foreach ($users as $user) {
    //         // ...
    //     }
    // });


    // $users = $query
    //     ->select('name', 'email as user_email')
    //     ->limit(10)
    //     ->get();

    // $user2 = $query
    //     ->select('name', 'email as user_email')
    //     ->addSelect('password')
    //     ->limit(10)
    //     ->get();

    // dd($users, $user2);


    // $users = $query
    //     ->select(DB::raw('count(*) as user_count, status'))
    //     ->where('status', '<>', 1)
    //     ->groupBy('status')
    //     ->toRawSql();

    // dd($users);


    // $users = DB::table('users')
    //     ->join('contacts', 'users.id', '=', 'contacts.user_id')
    //     ->join('orders', 'users.id', '=', 'orders.user_id')
    //     ->select('users.*', 'contacts.phone', 'orders.price')
    //     ->toRawSql();

    // dd($users);

    return view('welcome');
});

// Route::get('bt1', function () {

//     // 1. Truy vấn kết hợp nhiều bảng (JOIN):
//     $users = DB::table('users as u')
//         ->join('orders as o', 'u.id', '=', 'o.user_id')
//         ->select('u.name', DB::raw('SUM(o.amount) as total_spent'))
//         ->groupBy('u.name')
//         ->having('total_spent', '>', 1000)
//         ->get();

//     // 2. Truy vấn thống kê dựa trên khoảng thời gian (Time-based statistics):
//     $stats = DB::table('orders')
//         ->select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(*) as orders_count'), DB::raw('SUM(total_amount) as total_sales'))
//         ->whereBetween('order_date', ['2024-01-01', '2024-09-30'])
//         ->groupBy(DB::raw('DATE(order_date)'))
//         ->get();

//     // 3. Truy vấn để tìm kiếm giá trị không có trong tập kết quả khác (NOT EXISTS):
//     $products = DB::table('products as p')
//         ->whereNotExists(function ($query) {
//             $query->select(DB::raw(1))
//                 ->from('orders as o')
//                 ->whereColumn('o.product_id', 'p.id');
//         })
//         ->pluck('product_name');

//     // 4. Truy vấn với CTE (Common Table Expression):
//     // ...

//     // 5. Truy vấn lấy danh sách người dùng đã mua sản phẩm trong 30 ngày qua, cùng với thông tin sản phẩm và ngày mua
//     $users = DB::table('users as u')
//         ->join('orders as o', 'u.id', '=', 'o.user_id')
//         ->join('order_items as oi', 'o.id', '=', 'oi.order_id')
//         ->join('products as p', 'oi.product_id', '=', 'p.id')
//         ->select('u.name', 'p.product_name', 'o.order_date')
//         ->where('o.order_date', '>=', DB::raw('NOW() - INTERVAL 30 DAY'))
//         ->get();

//     // 6. Truy vấn lấy tổng doanh thu theo từng tháng, chỉ tính những đơn hàng đã hoàn thành
//     $revenues = DB::table('orders as o')
//         ->join('order_items as oi', 'o.id', '=', 'oi.order_id')
//         ->select(DB::raw("DATE_FORMAT(o.order_date, '%Y-%m') as order_month"), DB::raw('SUM(oi.quantity * oi.price) as total_revenue'))
//         ->where('o.status', '=', 'completed')
//         ->groupBy(DB::raw("DATE_FORMAT(o.order_date, '%Y-%m')"))
//         ->orderBy('order_month', 'DESC')
//         ->get();

//     // 7. Truy vấn các sản phẩm chưa từng được bán (sản phẩm không có trong bảng order_items)
//     $products = DB::table('products as p')
//         ->leftJoin('order_items as oi', 'p.id', '=', 'oi.product_id')
//         ->whereNull('oi.product_id')
//         ->pluck('product_name');

//     // 8. Lấy danh sách các sản phẩm có doanh thu cao nhất cho mỗi loại sản phẩm
//     $products = DB::table('products as p')
//         ->join(DB::raw('(SELECT product_id, SUM(quantity * price) AS total FROM order_items GROUP BY product_id) as oi'), 'p.id', '=', 'oi.product_id')
//         ->select('p.category_id', 'p.product_name', DB::raw('MAX(oi.total) as max_revenue'))
//         ->groupBy('p.category_id', 'p.product_name')
//         ->orderByDesc('max_revenue')
//         ->get();

//     // 9. Truy vấn thông tin chi tiết về các đơn hàng có giá trị lớn hơn mức trung bình
//     // ...

//     // 10. Truy vấn tìm tất cả các sản phẩm có doanh số cao nhất trong từng danh mục (category)
//     // ...
// });

// Route::get('bt2', function () {

//     // 1. Tính tổng doanh thu theo tháng
//     $sales = Sale::select(
//         DB::raw('SUM(total) as total_sales'),
//         DB::raw('EXTRACT(MONTH FROM sale_date) as month'),
//         DB::raw('EXTRACT(YEAR FROM sale_date) as year')
//     )
//         ->groupBy(DB::raw('EXTRACT(MONTH FROM sale_date)'), DB::raw('EXTRACT(YEAR FROM sale_date)'))
//         ->get();

//     // 2. Tính tổng chi phí theo tháng    
//     $expenses = Expense::select(
//         DB::raw('SUM(amount) as total_expenses'),
//         DB::raw('EXTRACT(MONTH FROM expense_date) as month'),
//         DB::raw('EXTRACT(YEAR FROM expense_date) as year')
//     )
//         ->groupBy(DB::raw('EXTRACT(MONTH FROM expense_date)'), DB::raw('EXTRACT(YEAR FROM expense_date)'))
//         ->get();

//     // 3. Tạo báo cáo tài chính cho một tháng
//     // Tính tổng doanh thu và tổng chi phí cho tháng 9, năm 2024
//     $total_sales = Sale::whereMonth('sale_date', 9)
//         ->whereYear('sale_date', 2024)
//         ->sum('total');

//     $total_expenses = Expense::whereMonth('expense_date', 9)
//         ->whereYear('expense_date', 2024)
//         ->sum('amount');

//     // Tính lợi nhuận trước thuế
//     $profit_before_tax = $total_sales - $total_expenses;

//     // Lấy thuế VAT
//     $tax_amount = Tax::where('tax_name', 'VAT')->value('rate');

//     // Tính lợi nhuận sau thuế
//     $profit_after_tax = $profit_before_tax - $tax_amount;

//     // Tạo báo cáo tài chính
//     FinancialReport::create([
//         'month' => 9,
//         'year' => 2024,
//         'total_sales' => $total_sales,
//         'total_expenses' => $total_expenses,
//         'profit_before_tax' => $profit_before_tax,
//         'tax_amount' => $tax_amount,
//         'profit_after_tax' => $profit_after_tax,
//     ]);

//     $query = DB::table('financial_reports');

//     // dd($sales->toArray(), $expenses->toArray());
// });



Route::resource('customers', CustomerController::class)->middleware('auth');
Route::delete('customers/{customer}/forceDestroy', [CustomerController::class, 'forceDestroy'])->name('customers.forceDestroy');

Route::resource('employees', EmployeeController::class);
Route::delete('employees/{employee}/forceDestroy', [EmployeeController::class, 'forceDestroy'])->name('employees.forceDestroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// BTB4
// Câu 1
Route::get('/movies', function () {
    echo "Đây là trang Movies";
    die;
})->middleware('check.age');

// Câu 2
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        echo "Đây là trang dành cho Admin";
        die;
    })->middleware('check.role:admin');

    Route::get('/orders', function () {
        echo "Đây là trang quản lý đơn hàng cho Nhân Viên";
        die;
    })->middleware('check.role:employee');

    Route::get('/profile', function () {
        echo "Đây là trang profile của Khách Hàng";
        die;
    })->middleware('check.role:customer');
});

// Câu 3
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        echo "Đây là trang Dashboard";
        die;
    });
});

Route::get('/register1', [AuthController::class, 'showRegisterForm'])->name('register1');
Route::post('/register1', [AuthController::class, 'register']);

Route::get('/login1', [AuthController::class, 'showLoginForm'])->name('login1');
Route::post('/login1', [AuthController::class, 'login']);

Route::get('/logout1', [AuthController::class, 'logout'])->name('logout1');
