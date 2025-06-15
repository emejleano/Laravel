@extends('layouts.customer')

@section('title')
    Category
@endsection

@section('content')
<div class="py-5 my-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>All Categories</h2>
            </div>
        </div>

        <div class="row">
            @if($category->count() > 0)
                @foreach ($category as $cate)
                    <div class="col-md-4 mb-4">
                        <a href="{{ url('view-category/' . $cate->slug) }}">
                            <div class="card h-100 position-relative">
                                <img src="{{ asset('upload/category/' . $cate->image) }}"
                                     class="card-img-top rounded lazy w-100"
                                     alt="{{ $cate->name }}"
                                     height="200px"
                                     style="object-fit: cover;">
                                <div class="text-light position-absolute top-50 start-50 translate-middle text-center">
                                    <h4 class="bg-dark bg-opacity-50 p-2 rounded" style="letter-spacing: 2px;">
                                        {{ $cate->name }}
                                    </h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <p class="text-center">No categories available at this time.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
