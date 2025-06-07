<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order; // Add this import

class DashboardController extends Controller
{
    public function index()
    {
        // Get all orders
        $orders = Order::latest()->get();
        
        // Calculate statistics
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', '1')->count();
        $pendingOrders = Order::where('status', '0')->count();
        
        // Get recent orders (last 5)
        $recentOrders = Order::latest()->take(5)->get();
        
        // Calculate total revenue from completed orders
        $totalRevenue = Order::where('status', '1')->sum('total_price');
        
        return view('admin.dashboard', compact(
            'orders',
            'totalOrders', 
            'completedOrders', 
            'pendingOrders', 
            'recentOrders', 
            'totalRevenue'
        ));
    }

    public function users()
    {
        $users = User::all();
        return view('Admin.users.index', compact('users'));
    }

    public function viewUser($id)
    {
        $users = User::find($id);
        return view('Admin.users.view', compact('users'));
    }
}