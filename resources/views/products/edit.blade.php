@extends('layouts.admin')

@section('title')
    <title>Edit Product</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Edit Produk
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama Produk</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Deskripsi Produk</label>
                                        <textarea id="description" name="description" class="form-control" required>{{ $product->description }}</textarea>
                                        <p class="text-danger">{{ $errors->first('description') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="status">Status Produk</label>

                                        <select name="status" class="form-control" id="" required>
                                            <option value="{{ $product->status }}" {{ old('status') == '1' ? 'selected' : '' }}>Publish</option>
                                            <option value="{{ $product->status }}" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                                        </select>
                                        <p class="text-danger">{{ $errors->first('status') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Kategori Produk</label>

                                        <select name="category_id" class="form-control" id="" required>
                                            <option value="">Pilih</option>
                                            @foreach ($category as $row)
                                            <option value="{{ $row->id }}" {{ $product->category_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->first('category_id') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Harga Produk</label>
                                        <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
                                        <p class="text-danger">{{ $errors->first('price') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="weight">Berat Produk</label>
                                        <input type="text" name="weight" class="form-control" value="{{ $product->weight }}" required>
                                        <p class="text-danger">{{ $errors->first('weight') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Foto Produk</label>
                                        <br>

                                        <img src="{{ asset('storage/products/' . $product->image) }}" width="100px" alt="{{ $product->name }}">

                                        <hr>

                                        <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                                        <p><strong>Biarkan kosong jika tidak ingin mengganti gambar</strong></p>
                                        <p class="text-danger">{{ $errors->first('image') }}</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm">Update</button>
                                    </div>
                          
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description')
    </script>
@endsection