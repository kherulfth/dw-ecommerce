<?php

namespace App\Http\Controllers;

use File;
use App\Product;
use App\Category;
use App\Jobs\ProductJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');

        if (request()->q != '') {
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }

        $product = $product->paginate(10);

        return view('products.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('name', 'Desc')->get();

        return view('products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required|',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);

            $product = new Product;
            $product->name = $request['name'];
            $product->slug = $request['name'];
            $product->category_id = $request['category_id'];
            $product->description = $request['description'];
            $product->status = $request['status'];
            $product->image = $filename;
            $product->price = $request['price'];
            $product->weight = $request['weight'];
            $product->save();
        }

        return redirect(route('product.index'))->with(['success' => 'Produk Baru Ditambahkan !']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::orderBy('name', 'DESC')->get();

        return view('products.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required|',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        $product = Product::find($id);
        $filename = $product->image;

        // dd($product->id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);
            File::delete(storage_path('app/public/products/' . $product->image));
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'image' => $filename
        ]);

        return redirect(route('product.index'))->with(['success' => 'Produk Baru Diperbaharui !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        File::delete(storage_path('app/public/products/' . $product->image));

        $product->delete();

        return redirect(route('product.index'))->with(['success' => 'Produk Sudah Dihapus !']);

    }

    public function massUploadForm(){
        $category = Category::orderBy('name', 'DESC')->get();

        return view('products.bulk', compact('category'));
    }

    public function massUpload(Request $request){
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = time() . '-product.' . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $filename);

            ProductJob::dispatch($request->category_id, $filename);

            return redirect()->back()->with(['success' => 'Upload Produk Dijadwalkan !']);

        }

    }
}
