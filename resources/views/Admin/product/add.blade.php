@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
      <h4>Add Products</h4>
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

        <form method="POST" action="{{ url('insert-product') }}" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <select class="form-select border border-dark p-2" name="cate_id">
                        <option value="">Select a Category</option>
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}" {{ old('cate_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control border border-dark p-2" name="name" value="{{ old('name') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Slug</label>
                    <input type="text" class="form-control border border-dark p-2" name="slug" value="{{ old('slug') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Small Description</label>
                    <textarea name="small_description" rows="3" class="form-control border border-dark">{{ old('small_description') }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" rows="3" class="form-control border border-dark">{{ old('description') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Original Price</label>
                    <input type="number" class="form-control border border-dark p-2" name="original_price" value="{{ old('original_price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Selling Price</label>
                    <input type="number" class="form-control border border-dark p-2" name="selling_price" value="{{ old('selling_price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control border border-dark p-2" name="qty" value="{{ old('qty') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tax</label>
                    <input type="number" class="form-control border border-dark p-2" name="tax" value="{{ old('tax') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label><br>
                    <input type="checkbox" name="status" {{ old('status') ? 'checked' : '' }}>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Trending</label><br>
                    <input type="checkbox" name="trending" {{ old('trending') ? 'checked' : '' }}>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Meta Title</label>
                    <input type="text" class="form-control border border-dark p-2" name="meta_title" value="{{ old('meta_title') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Meta Keyword</label>
                    <textarea name="meta_keyword" rows="3" class="form-control border border-dark p-2">{{ old('meta_keyword') }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control border border-dark p-2">{{ old('meta_description') }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Upload Image</label>
                    <input type="file" name="image" class="form-control border border-dark p-2">
                </div>

                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
