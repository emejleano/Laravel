@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Kategori</h4>
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

        {{-- ✅ Form tambah kategori --}}
        <form method="POST" action="{{ url('insert-category') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="">Nama Kategori</label>
                    <input type="text" class="form-control border border-dark" name="name" value="{{ old('name') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Slug</label>
                    <input type="text" class="form-control border border-dark" name="slug" value="{{ old('slug') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control border border-dark">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Status</label><br>
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status') ? 'checked' : '' }}> Aktif
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Popular</label><br>
                    <input type="hidden" name="popular" value="0">
                    <input type="checkbox" name="popular" value="1" {{ old('popular') ? 'checked' : '' }}> Tampilkan di Beranda
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Meta Title</label>
                    <input type="text" class="form-control border border-dark" name="meta_title" value="{{ old('meta_title') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Meta Keyword</label>
                    <textarea name="meta_keyword" rows="3" class="form-control border border-dark">{{ old('meta_keyword') }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control border border-dark">{{ old('meta_description') }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Upload Gambar</label>
                    <input type="file" name="image" class="form-control border border-dark">
                </div>
                <div class="col-md-12 mb-3 text-end">
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
