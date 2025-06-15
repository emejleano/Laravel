@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Update Product</h4>
    </div>
    <div class="card-body">

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('update-product/'.$product->id) }}" enctype="multipart/form-data"> 
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Jika ingin ubah kategori --}}
                {{-- <div class="col-md-12 mb-3">
                    <label>Category</label>
                    <select class="form-select border border-dark p-2" name="cate_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->cate_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control border border-dark p-2" name="name" value="{{ $product->name }}">
                </div>    

                <div class="col-md-6 mb-3">
                    <label>Slug</label>
                    <input type="text" class="form-control border border-dark p-2" name="slug" value="{{ $product->slug }}">
                </div> 

                <div class="col-md-12 mb-3">
                    <label>Small Description</label>
                    <textarea name="small_description" rows="3" class="form-control p-2 border border-dark">{{ $product->small_description }}</textarea>   
                </div>    

                <div class="col-md-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" rows="3" class="form-control p-2 border border-dark">{{ $product->description }}</textarea>   
                </div>

                <div class="col-md-6 mb-3">
                    <label>Original Price</label>
                    <input type="number" class="form-control border border-dark p-2" name="original_price" value="{{ $product->original_price }}">
                </div> 

                <div class="col-md-6 mb-3">
                    <label>Selling Price</label>
                    <input type="number" class="form-control border border-dark p-2" name="selling_price" value="{{ $product->selling_price }}">
                </div> 

                <div class="col-md-6 mb-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control border border-dark p-2" name="qty" value="{{ $product->qty }}">
                </div> 

                <div class="col-md-6 mb-3">
                    <label>Tax</label>
                    <input type="number" class="form-control border border-dark p-2" name="tax" value="{{ $product->tax }}">
                </div> 

                <div class="col-md-6 mb-3">
                    <label>Status</label><br>
                    <input type="checkbox" name="status" {{ $product->status == "1" ? "checked" : "" }}>
                </div>    

                <div class="col-md-6 mb-3">
                    <label>Trending</label><br>
                    <input type="checkbox" name="trending" {{ $product->trending == "1" ? "checked" : "" }}>
                </div>    

                <div class="col-md-6 mb-3">
                    <label>Meta Title</label>
                    <input type="text" class="form-control border border-dark p-2" name="meta_title" value="{{ $product->meta_title }}">
                </div>    

                <div class="col-md-12 mb-3">
                    <label>Meta Keyword</label>
                    <textarea name="meta_keyword" rows="3" class="form-control border border-dark p-2">{{ $product->meta_keyword }}</textarea> 
                </div>    

                <div class="col-md-12 mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control border border-dark p-2">{{ $product->meta_description }}</textarea> 
                </div>    

                <div class="col-md-12 mb-3">
                    <label>Current Image</label><br>
                    @if ($product->image)
                        <img src="{{ asset('upload/product/'.$product->image) }}" class="w-25 h-25" alt="no image">
                    @endif
                </div>

                <div class="col-md-12 mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control border border-dark p-2">
                </div>    

                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>    
            </div>    
        </form>
    </div>
</div>
@endsection
