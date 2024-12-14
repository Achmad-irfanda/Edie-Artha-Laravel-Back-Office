<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionWorkshop;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrxBengkelResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrxWorkshopController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'alamat' => ['required', 'string', 'max:255'],
                'kendala' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required'],
                'jenis_kendaraan' => ['required'],
                'plat_nomor' => ['required'],
                'gambar' => ['required', 'image'], // Ensure the file is an image
            ]);

            $id = Auth::user()->id;

            // Create the transaction record
            $response = TransactionWorkshop::create([
                'user_id' => $id,
                'alamat' => $request->alamat,
                'kendala' => $request->kendala,
                'deskripsi' => $request->deskripsi,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'plat_nomor' => $request->plat_nomor,
                'status' => 'pending',
            ]);

            // Check if the request has a file for 'gambar'
            if ($request->hasFile('gambar')) {
                // If there is an existing image, delete it
                if ($response->gambar) {
                    // Get the old image path
                    $oldImagePath = public_path($response->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Generate a new filename
                $fileName = 'gambar-' . time() . '.' . $request->file('gambar')->getClientOriginalExtension();

                // Store the new image
                $path = $request->file('gambar')->storeAs('public/uploads/tranbengkel', $fileName);

                // Generate the public URL for the uploaded file
                $reqPath = Storage::url($path);

                // Update the response with the new image path
                $response->update([
                    'gambar' => $reqPath, // Use the generated URL
                ]);
            }

            $trx = TransactionWorkshop::find($response->id);

            DB::commit();

            return ResponseFormatter::success([
                'transaction' =>  $trx,
            ], 'Transaction Stored');
            
        } catch (Exception $error) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => 'Shometing went wrong',
                'error' => $error,
            ], 500);
        }
    }

    public function getTrx(Request $request)
    {
        $trx = TransactionWorkshop::with('mekanik')->find($request->input('id'));
        return ResponseFormatter::success([
            'transaction' => new TrxBengkelResource($trx),
        ], 'Transaction Stored');
    }

    public function allTrx(Request $request)
    {
        $trx = TransactionWorkshop::with('mekanik')->where('user_id', Auth::user()->id)->get();
        if ($request->input('status') == 'process') {
            $trx = TransactionWorkshop::with('mekanik')->where('user_id', Auth::user()->id)->where('status', 'pending')->orWhere('status', 'process')->latest()->get();
        }
        if ($request->input('status') == 'success') {
            $trx = TransactionWorkshop::with('mekanik')->where('user_id', Auth::user()->id)->where('status', 'success')->orWhere('status', 'canceled')->latest()->get();
        }

        return ResponseFormatter::success([
            'transaction' => TrxBengkelResource::collection($trx),
        ], 'Transaction Stored');
    }

    public function rating(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'rating' => ['required', 'max:255'],
                'trx_id' => ['required']
            ]);
            $trx = TransactionWorkshop::find($request->trx_id);
            $trx->update(['rating' => $request->rating]);

            $response = TransactionWorkshop::find($request->trx_id);
            DB::commit();
            return ResponseFormatter::success([
                'transaction' => new TrxBengkelResource($trx),
            ], 'success');
        } catch (Exception $error) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => 'Shometing went wrong',
                'error' => $error,
            ], 500);
        }
    }
}
