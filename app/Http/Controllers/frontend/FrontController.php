<?php 
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class FrontController extends Controller
{
    /**
     * Menampilkan halaman utama dengan kategori populer dan produk trending
     */
    public function mainpage()
    {
        $category = Category::where('popular', '1')->take(15)->get();
        $product = Product::where('trending', '1')->take(12)->get();
        return view('frontend.index', compact('category', 'product'));
    }

    /**
     * Menampilkan semua kategori yang status-nya aktif (status = 0)
     */
    public function category()
    {
        $category = Category::all();
        return view('frontend.category', compact('category'));
    }

    /**
     * Menampilkan produk berdasarkan slug kategori - VERSI DEBUG
     */
    public function viewCategory($slug)
    {
        // Cek apakah kategori dengan slug ini ada
        $category = Category::where('slug', $slug)->first();
        
        if (!$category) {
            // Jika tidak ada, tampilkan pesan debug
            return redirect('/')->with('status', 'Category not found. Slug: ' . $slug);
        }

        // Coba ambil semua produk dari kategori ini tanpa filter status dulu
        $all_products = Product::where('cate_id', $category->id)->get();
        
        // Jika tidak ada produk sama sekali
        if ($all_products->isEmpty()) {
            // Debug: tampilkan info kategori
            $debug_info = "Category found: {$category->name} (ID: {$category->id}), but no products found. ";
            $debug_info .= "Total products in database: " . Product::count();
            
            return redirect('/')->with('status', $debug_info);
        }

        // Filter produk yang aktif (status = 1)
        $active_products = $all_products->where('status', '1');
        
        // Jika ada produk tapi tidak ada yang aktif
        if ($active_products->isEmpty()) {
            $debug_info = "Found {$all_products->count()} products for category '{$category->name}', ";
            $debug_info .= "but none are active (status=1). Product statuses: ";
            $debug_info .= $all_products->pluck('status')->unique()->join(', ');
            
            return redirect('/')->with('status', $debug_info);
        }

        // Gunakan produk yang aktif
        $product = $active_products;
        
        return view('frontend.products.index', compact('category', 'product'));
    }

    /**
     * Method khusus untuk debug data
     */
    public function debugCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        
        if (!$category) {
            $all_slugs = Category::pluck('slug', 'name')->toArray();
            return response()->json([
                'error' => 'Category not found',
                'searched_slug' => $slug,
                'available_categories' => $all_slugs
            ]);
        }

        $products = Product::where('cate_id', $category->id)->get();
        
        return response()->json([
            'category' => $category,
            'products_count' => $products->count(),
            'products' => $products->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'status' => $p->status,
                    'cate_id' => $p->cate_id
                ];
            })
        ]);
    }

    /**
     * Menampilkan detail produk berdasarkan kategori dan slug produk
     */
    public function productView($cate_slug, $prod_slug)
    {
        if (Category::where('slug', $cate_slug)->exists()) {
            if (Product::where('slug', $prod_slug)->exists()) {
                $product = Product::where('slug', $prod_slug)->first();
                return view('frontend.products.view', compact('product'));
            } else {
                return redirect('/')->with('status', "No such product found");
            }
        } else {
            return redirect('/')->with('status', "No such category found");
        }
    }

    /**
     * Menampilkan detail produk langsung dari slug produk (tanpa slug kategori)
     */
    public function eachProdView($prod_slug)
    {
        if (Product::where('slug', $prod_slug)->exists()) {
            $product = Product::where('slug', $prod_slug)->first();
            return view('frontend.products.view', compact('product'));
        } else {
            return redirect('/')->with('status', "No such product found");
        }
    }

    /**
     * Fitur pencarian produk berdasarkan nama
     */
    public function searchProducts(Request $request)
    {
        $search_product = $request->product_name;
        if ($search_product != "") {
            $product = Product::where('name', "LIKE", "%$search_product%")->first();
            if ($product && $product->category) {
                return redirect('view-category/' . $product->category->slug . '/' . $product->slug);
            } else {
                return redirect()->back()->with("status", "No products matched your search");
            }
        } else {
            return redirect()->back();
        }
    }
}