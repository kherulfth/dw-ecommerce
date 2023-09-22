@extends('layouts.admin')

@section('title')
    <title>List Product</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    List Product
                                    <div class="float-right">
                                        <a href="{{ route('product.bulk') }}" class="btn btn-danger btn-sm float-right">Mass Upload</a>
                                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
                                    </div>
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('category.index') }}" method="get">
                                    <div class="input-group mb-3 col-md-3 float-right">
                                        <input type="text" name="q" class="form-control" placeholder="Cari ..." value="{{ request()->q }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button">Cari</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <th>#</th>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($product as $row)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/products/' . $row->image) }}" alt="{{ $row->name }}" width="100px" height="100px">
                                                </td>
                                                <td>
                                                    <strong>{{ $row->name }}</strong>
                                                    <br>
                                                    <label for="">Kategori : <span class="badge badge-info">{{ $row->category->name }}</span></label>
                                                    <label for="">Berat : <span class="badge badge-info">{{ $row->weight }} gr</span></label>
                                                </td>
                                                <td>Rp. {{ number_format($row->price) }}</td>
                                                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                                <td>{!! $row->status_label !!}</td>
                                                <td>
                                                    <form action="{{ route('product.destroy', $row ?? ''->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
    
                                                        <a href="{{ route('product.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>    
                                            @empty
                                            <tr>
                                                <td class="text-center" colspan="6">Tidak Ada Data</td>    
                                            </tr>    
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {!! $product->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection