@extends('layouts.customer')

@section('title')
   Check Out
@endsection

@section('content')

{{-- Tampilkan pesan sukses jika ada --}}
@if (session('status'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<div class="py-5"></div>
<div class="container mt-3">
    <form action="{{ url('place-order') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0">
                    <div class="card-body">
                        <h5>Basic Detail</h5>
                        <hr>
                        <div class="row checkout-form">
                            <div class="col-md-6 my-2">
                                <label for="firstname">Nama Lengkap</label>
                                <input type="text" name="fname" class="form-control" value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="email@example.com" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="phoneno">Phone Number</label>
                                <input type="number" name="phoneno" class="form-control" value="{{ Auth::user()->phoneno }}" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="address1">Alamat</label>
                                <input type="text" name="address1" class="form-control" value="{{ Auth::user()->address1 }}" placeholder="Contoh: Bekasi Indah" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="city">Kota/Kabupaten</label>
                                <input type="text" name="city" class="form-control" value="{{ Auth::user()->city }}" placeholder="Kota Tangerang" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="state">Kecamatan</label>
                                <input type="text" name="state" class="form-control" value="{{ Auth::user()->state }}" placeholder="Tigaraksa" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="country">Negara</label>
                                <input type="text" name="country" class="form-control" value="{{ Auth::user()->country }}" placeholder="Indonesia" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="pincode">Kode Pos</label>
                                <input type="number" name="pincode" class="form-control" value="{{ Auth::user()->pincode }}" placeholder="1720" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Order Detail --}}
            <div class="col-md-5">
                <div class="card border-0">
                    <div class="card-body">
                        <h5>Order Detail</h5>
                        <hr>
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartitem as $item)
                                    <tr>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->prod_qty }}</td>
                                        <td>Rp{{ number_format($item->products->selling_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <button type="submit" class="btn btn-outline-primary float-end">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('css')
<style>
.checkout-form input {
    font-size: 1rem;
    padding: 10px;
    font-weight: 400;
}
.checkout-form label {
    font-size: .9rem;
    font-weight: 700;
}
</style>
@endsection
