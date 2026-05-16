<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Katalog Pintar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #0d6efd; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-rocket me-2"></i> Dasbor Katalog Pintar</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm mb-5 p-4">
            <h5 class="fw-bold mb-3">Tambah Produk</h5>
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="nama_produk" class="form-control form-control-lg" placeholder="Nama Produk" required>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="foto" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

        <h5 class="fw-bold mb-4">Katalog Saya</h5>
        <div class="row g-4 mb-5">
            @forelse($produks as $item)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $item->name }}</h6>
                            <div class="mt-3 d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary w-100">Edit</button>
                                <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="w-100">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Hapus produk?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Belum ada produk. Silakan tambah produk baru.</div>
            @endforelse
        </div>
    </div>
</body>
</html>