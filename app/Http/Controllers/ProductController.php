<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('image')->get();
        return view('retail.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('retail.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $varian = json_encode($request->input('varian'));

            //  Thumbnail
            $fileName = 'spt' . $request->kode;
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $fileName = $fileName . '-' . time() . '.' . $extension;

            $request->file('thumbnail')->storeAs('public/uploads/sparepart', $fileName);
            $url = 'storage/uploads/sparepart/' . $fileName;

            $product = Product::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'varian' => $varian,
                'stok' => $request->stok,
                'status' => $request->status,
                'harga' => $request->harga,
                'thumbnail' => $url,
            ]);

            if ($request->hasFile("images")) {
                $files = $request->file("images");
                foreach ($files as $file) {
                    $fileName = time() . '-' . $file->getClientOriginalName();

                    $file->storeAs('public/uploads/sparepart', $fileName);
                    $url = 'storage/uploads/sparepart/' . $fileName;

                    Image::create([
                        'product_id' => $product->id,
                        'url' => $url,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {

            dd('error', $e);
            // Rollback
            DB::rollback();
            return redirect()->back()->with('warning', 'Something Went Wrong!');
        }
        return redirect()->route('product.index')->with('success', 'Sparepart Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $images = Image::where('product_id', $product->id)->get();
        return view('retail.product.edit', compact('product', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $varian = json_encode($request->input('varian'));


            $product->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'varian' => $varian,
                'stok' => $request->stok,
                'status' => $request->status,
                'harga' => $request->harga,
            ]);

            if ($request->hasFile("thumbnail")) {
                // Delete Thumbnail
                unlink(public_path($product->thumbnail));

                //  Thumbnail
                $fileName = 'spt' . $request->kode;
                $extension = $request->file('thumbnail')->getClientOriginalExtension();
                $fileName = $fileName . '-' . time() . '.' . $extension;

                $request->file('thumbnail')->storeAs('public/uploads/sparepart', $fileName);
                $url = 'storage/uploads/sparepart/' . $fileName;

                $product->update([
                    'thumbnail' => $url,
                ]);
            }


            if ($request->hasFile("images")) {
                $files = $request->file("images");
                // Hapus Images
                $images = Image::where('product_id', $product->id)->get();
                foreach ($images as $image) {
                    unlink(public_path($image->url));
                    // Delete Image
                    Image::destroy($image->id);
                }
                foreach ($files as $file) {
                    $fileName = time() . '-' . $file->getClientOriginalName();

                    $file->storeAs('public/uploads/sparepart', $fileName);
                    $url = 'storage/uploads/sparepart/' . $fileName;

                    Image::create([
                        'product_id' => $product->id,
                        'url' => $url,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {

            dd('error', $e);
            // Rollback
            DB::rollback();
            return redirect()->back()->with('warning', 'Something Went Wrong!');
        }
        return redirect()->route('product.index')->with('success', 'Sparepart Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus Image
        $images = Image::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            unlink(public_path($image->url));
            // Delete Image
            Image::destroy($image->id);
        }

        // Delete Product
        unlink(public_path($product->thumbnail));
        Product::destroy($product->id);
        return back();
    }
}
