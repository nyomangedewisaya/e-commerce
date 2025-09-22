<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);
        $availableYears = Order::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');

        $startOfThisMonth = Carbon::create($selectedYear, Carbon::now()->month)->startOfMonth();
        $endOfThisMonth = $startOfThisMonth->copy()->endOfMonth();
        $startOfLastMonth = $startOfThisMonth->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $startOfLastMonth->copy()->endOfMonth();

        $baseOrderQuery = Order::where('status', 'success')->whereYear('created_at', $selectedYear);
        $availableProducts = Product::where('stock', '>', 0)->count();
        $usedCategories = Category::whereHas('products')->count();
        $categoriesTotal = Category::count();

        $productsAddedThisMonth = Product::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        $productsAddedLastMonth = Product::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $categoriesAddedThisMonth = Category::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        $categoriesAddedLastMonth = Category::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $ordersForPeriod = Order::where('status', 'success')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfThisMonth])
            ->get();

        $salesThisMonth = $ordersForPeriod->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        $salesLastMonth = $ordersForPeriod->whereBetween('created_at', [$startOfLastMonth, $endOfThisMonth])->count();
        $revenueThisMonth = $ordersForPeriod->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->sum('total_amount');
        $revenueLastMonth = $ordersForPeriod->whereBetween('created_at', [$startOfLastMonth, $endOfThisMonth])->sum('total_amount');

        $salesTotal = (clone $baseOrderQuery)->count();
        $revenueTotal = (clone $baseOrderQuery)->sum('total_amount');

        $productsPercentageChange = $this->calculatePercentageChange($productsAddedThisMonth, $productsAddedLastMonth);
        $categoriesPercentageChange = $this->calculatePercentageChange($categoriesAddedThisMonth, $categoriesAddedLastMonth);
        $salesPercentageChange = $this->calculatePercentageChange($salesThisMonth, $salesLastMonth);
        $revenuePercentageChange = $this->calculatePercentageChange($revenueThisMonth, $revenueLastMonth);
        $monthlyData = (clone $baseOrderQuery)->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as sales_count'), DB::raw('SUM(total_amount) as revenue_sum'))->groupBy('month')->orderBy('month', 'asc')->get()->keyBy('month'); // Jadikan bulan sebagai key untuk akses mudah

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $salesData = [];
        $revenueData = [];

        for ($month = 1; $month <= 12; $month++) {
            $salesData[] = $monthlyData->get($month)->sales_count ?? 0;
            $revenueData[] = ($monthlyData->get($month)->revenue_sum ?? 0) / 1000000; 
        }

        $paymentMethodData = Payment::join('orders', 'payments.order_id', '=', 'orders.id')->whereYear('orders.created_at', $selectedYear)->select('method', DB::raw('count(*) as total'))->groupBy('method')->get();
        $paymentLabels = $paymentMethodData->pluck('method')->map(fn($m) => ucwords(str_replace('_', ' ', $m)))->toArray();
        $paymentTotals = $paymentMethodData->pluck('total')->toArray();

        $latestProducts = Product::latest()->take(5)->get();
        $lowestStockProducts = Product::orderBy('stock', 'asc')->take(5)->get();

        $popularProducts = Product::select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success') 
            ->whereYear('orders.created_at', $selectedYear)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $orderStatsData = Order::whereYear('created_at', $selectedYear)->select('status', DB::raw('COUNT(*) as count'))->groupBy('status')->pluck('count', 'status');

        $orderStats = [
            'success' => $orderStatsData->get('success', 0),
            'pending' => $orderStatsData->get('pending', 0),
            'cancelled' => $orderStatsData->get('cancelled', 0),
            'failed' => $orderStatsData->get('failed', 0),
        ];

        return view('admin.dashboard', compact(
            'availableYears', 'selectedYear', 'availableProducts', 'productsPercentageChange', 
            'usedCategories', 'categoriesTotal', 'categoriesPercentageChange', 'salesTotal', 
            'salesPercentageChange', 'revenueTotal', 'revenuePercentageChange', 'chartLabels', 
            'salesData', 'revenueData', 'latestProducts', 'lowestStockProducts', 'popularProducts', 
            'orderStats', 'paymentLabels', 'paymentTotals'
        ));
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
