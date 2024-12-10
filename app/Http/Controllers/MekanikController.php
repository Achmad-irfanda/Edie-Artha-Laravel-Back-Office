<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mekaniks = Mekanik::all();
        return view('bengkel.mekanik.index', compact('mekaniks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bengkel.mekanik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            //  Image
            $fileName = 'photo' . $request->kode;
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $fileName . '-' . time() . '.' . $extension;

            $request->file('image')->storeAs('public/uploads/mekanik', $fileName);
            $url = 'storage/uploads/mekanik/' . $fileName;

            $mekanik = Mekanik::create([
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'cabang' => $request->cabang,
                'image' => $url,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            dd('error', $e);
            // Rollback
            DB::rollback();
            return redirect()->back()->with('warning', 'Something Went Wrong!');
        }
        return redirect()->route('mekanik.index')->with('success', 'Mekanik Added Successfully!');
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
    public function edit(Mekanik $mekanik)
    {
        return view('bengkel.mekanik.edit', compact('mekanik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mekanik $mekanik)
    {
        DB::beginTransaction();
        try {

            $mekanik->update([
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'cabang' => $request->cabang,
            ]);

            if ($request->hasFile("image")) {
                // Delete Image
                unlink(public_path($mekanik->image));

                //  Thumbnail
                $fileName = 'photo' . $request->kode;
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $fileName . '-' . time() . '.' . $extension;

                $request->file('image')->storeAs('public/uploads/mekanik', $fileName);
                $url = 'storage/uploads/mekanik/' . $fileName;

                $mekanik->update([
                    'image' => $url,
                ]);
            }


            DB::commit();
        } catch (\Exception $e) {

            dd('error', $e);
            // Rollback
            DB::rollback();
            return redirect()->back()->with('warning', 'Something Went Wrong!');
        }
        return redirect()->route('mekanik.index')->with('success', 'Makenik Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mekanik $mekanik)
    {
        // Hapus Image
        unlink(public_path($mekanik->image));
        // Delete Product
        Mekanik::destroy($mekanik->id);
        return back();
    }
}
