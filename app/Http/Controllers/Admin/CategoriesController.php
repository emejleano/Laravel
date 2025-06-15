<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('Admin.category.index', compact('category'));
    }

    public function add()
    {
        return view('Admin.category.add');
    }

    public function insert(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
    'name' => 'required',
    'slug' => 'required',
    'description' => 'required',
    'meta_title' => 'required',
    'meta_keyword' => 'required',
    'meta_description' => 'required',
    'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
], [
    'name.required' => 'Nama kategori wajib diisi.',
    'slug.required' => 'Slug wajib diisi.',
    'description.required' => 'Deskripsi wajib diisi.',
    'meta_title.required' => 'Meta Title wajib diisi.',
    'meta_keyword.required' => 'Meta Keyword wajib diisi.',
    'meta_description.required' => 'Meta Description wajib diisi.',
    'image.required' => 'Gambar kategori wajib diunggah.',
    'image.image' => 'File harus berupa gambar.',
    'image.mimes' => 'Gambar harus berekstensi jpeg, png, atau jpg.',
    'image.max' => 'Ukuran gambar maksimal 2MB.',
]);



        $category = new Category();

        // ✅ Upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('upload/category', $fileName);
            $category->image = $fileName;
        }

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == true ? '1' : '0';
        $category->popular = $request->input('popular') == true ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');

        $category->save();
        return redirect('/categories')->with('status', "Category Added Successfully");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('Admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // ✅ Validasi input (gambar tidak wajib saat update)
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ✅ Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            $path = 'upload/category/' . $category->image;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('upload/category', $fileName);
            $category->image = $fileName;
        }

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == true ? '1' : '0';
        $category->popular = $request->input('popular') == true ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');

        $category->update();
        return redirect('/categories')->with('status', "Category Updated Successfully");
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            $path = 'upload/category/' . $category->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $category->delete();
        return redirect('/categories')->with('status', "Category deleted Successfully");
    }
}
