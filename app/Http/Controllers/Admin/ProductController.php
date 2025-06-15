<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('Admin.product.index', compact('products'));
    }

    public function add()
    {
        $category = Category::all();
        return view('Admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'cate_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'small_description' => 'required|string',
            'description' => 'required|string',
            'original_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|integer',
            'tax' => 'required|numeric',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama belum lengkap. Harap isi semua kolom yang wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'slug.unique' => 'Slug sudah digunakan. Gunakan yang berbeda.',
        ]);

        $product = new Product();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('upload/product', $fileName);
            $product->image = $fileName;
        }

        $product->cate_id = $request->input('cate_id');
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->small_description = $request->input('small_description');
        $product->description = $request->input('description');
        $product->original_price = $request->input('original_price');
        $product->selling_price = $request->input('selling_price');
        $product->qty = $request->input('qty');
        $product->tax = $request->input('tax');
        $product->status = $request->input('status') == true ? '1' : '0';
        $product->trending = $request->input('trending') == true ? '1' : '0';
        $product->meta_title = $request->input('meta_title');
        $product->meta_keyword = $request->input('meta_keyword');
        $product->meta_description = $request->input('meta_description');

        $product->save();
        return redirect('/products')->with('status', "Product Added Successfully");
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('Admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // ✅ Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'small_description' => 'required|string',
            'description' => 'required|string',
            'original_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|integer',
            'tax' => 'required|numeric',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'required' => 'Data belum lengkap. Harap isi semua kolom yang wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $path = 'upload/product/' . $product->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('upload/product', $fileName);
            $product->image = $fileName;
        }

        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->small_description = $request->input('small_description');
        $product->description = $request->input('description');
        $product->original_price = $request->input('original_price');
        $product->selling_price = $request->input('selling_price');
        $product->qty = $request->input('qty');
        $product->tax = $request->input('tax');
        $product->status = $request->input('status') == true ? '1' : '0';
        $product->trending = $request->input('trending') == true ? '1' : '0';
        $product->meta_title = $request->input('meta_title');
        $product->meta_keyword = $request->input('meta_keyword');
        $product->meta_description = $request->input('meta_description');

        $product->update();
        return redirect('/products')->with('status', "Product Updated Successfully");
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $path = 'upload/product/' . $product->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $product->delete();
        return redirect('/products')->with('status', "Product deleted Successfully");
    }
}
