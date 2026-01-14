<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ============================================
    // DASHBOARD
    // ============================================

    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'revenue' => Order::sum('total_price'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    // ============================================
    // PRODUCTS CRUD
    // ============================================

    public function products()
    {
        $products = Product::with('category')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Proizvod je uspešno kreiran.');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Proizvod je uspešno ažuriran.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Proizvod je uspešno obrisan.');
    }

    // ============================================
    // CATEGORIES CRUD
    // ============================================

    public function categories()
    {
        $categories = Category::withCount('products')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories')->with('success', 'Kategorija je uspešno kreirana.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories')->with('success', 'Kategorija je uspešno ažurirana.');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Ne možete obrisati kategoriju koja ima proizvode.');
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Kategorija je uspešno obrisana.');
    }

    // ============================================
    // ORDERS
    // ============================================

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Status narudžbine je ažuriran.');
    }

    // ============================================
    // USERS
    // ============================================

    public function users()
    {
        $users = User::withCount('orders')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return redirect()->back()->with('success', 'Admin status korisnika je ažuriran.');
    }
}
