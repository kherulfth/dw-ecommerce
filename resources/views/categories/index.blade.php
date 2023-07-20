@extends('layouts.admin')

@section('title')
    <title>List Kategori</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="card-title">Kategori Baru</h4>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="card-title">List Kategori</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th>#</th>
                                        <th>Kategori</th>
                                        <th>Parent</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        @forelse ($category as $val)
                                        <tr>
                                            <td></td>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->parent ? $val->parent->name:'-' }}</td>
                                            <td>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <form action="{{ route('category.destroy', $val->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="{{ route('category.edit', $val->id) }}" class="btn btn warning btn-sm">Edit</a>
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>    
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="5">Tidak Ada Data</td>    
                                        </tr>    
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {!! $category->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection