@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Update Category</h4>
    </div>
    <div class="card-body">

        {{-- ✅ Notifikasi error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Form update kategori --}}
        <form method="POST" action="{{ url('update-category/'.$category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="form-control border border-dark p-2">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                        class="form-control border border-dark p-2">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control border border-dark p-2">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label><br>
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $category->status) == "1" ? 'checked' : '' }}> Aktif
                </div>

                <div class="col-md-6 mb-3">
                    <label>Popular</label><br>
                    <input type="hidden" name="popular" value="0">
                    <input type="checkbox" name="popular" value="1" {{ old('popular', $category->popular) == "1" ? 'checked' : '' }}> Tampilkan di beranda
                </div>

                <div class="col-md-6 mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}"
                        class="form-control border border-dark p-2">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Meta Keyword</label>
                    <textarea name="meta_keyword" rows="3" class="form-control border border-dark p-2">{{ old('meta_keyword', $category->meta_keyword) }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control border border-dark p-2">{{ old('meta_description', $category->meta_description) }}</textarea>
                </div>

                @if ($category->image)
                    <div class="col-md-12 mb-3">
                        <label>Gambar Saat Ini:</label><br>
                        <img src="{{ asset('upload/category/'.$category->image) }}" alt="Category Image"
                            class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif

                <div class="col-md-12 mb-3">
                    <label>Upload Gambar Baru</label>
                    <input type="file" name="image" class="form-control border border-dark p-2">
                </div>

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
