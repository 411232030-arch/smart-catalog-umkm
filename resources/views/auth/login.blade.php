@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0">Masuk ke Smart-Catalog</h5>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger small">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="text-center mt-3">
                        <small>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection