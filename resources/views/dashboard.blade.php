@extends('layouts.app')

@section('content')
<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Smart-Catalog UMKM</h4>
        
        {{-- Pesan Selamat Datang Dinamis  --}}
        @if(Auth::check())
            <p>Selamat Datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        @endif

        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" required>
                </div>
                <div class="col-md-4">
                    <input type="file" name="foto" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </div>
        </form>

        <hr class="my-4">
        <h5>Katalog Saya</h5>
        <div class="row">
            @foreach($categories as $item)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/uploads/' . $item->image) }}" class="card-img-top">
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->name }}</h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection