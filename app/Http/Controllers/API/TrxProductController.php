<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\TransactionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrxProductResource;
use App\Models\Product;
use App\Models\TransactionProductItem;
use Illuminate\Support\Facades\Auth;

class TrxProductController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'alamat' => ['required', 'string', 'max:255'],
                'jasa_pasang' => ['required'],
                'pembayaran' => ['required'],
            ]);
            $id = Auth::user()->id;

            $trx = TransactionProduct::create([
                'user_id' => $id,
                'alamat' => $request->alamat,
                'jasa_pasang' => $request->jasa_pasang,
                'pembayaran' => $request->pembayaran,
                'status' => 'pending',
            ]);

            $grandTotal = 0;
            if ($request->items) {
                foreach ($request->items as $product) {
                    $prod = Product::find($product['product']);
                    $total = $product['kuantitas'] * $prod->harga;
                    TransactionProductItem::create([
                        'product_id' => $product['product'],
                        'varian' => $product['varian'],
                        'kuantitas' => $product['kuantitas'],
                        'harga' => $prod->harga,
                        'transaction_product_id' => $trx->id,
                        'total' => $total,
                    ]);

                    $grandTotal += $total;
                }
            }

            $trx->update(['total' => $grandTotal]);

            $response = TransactionProduct::with('items.product')->where('id', $trx->id)->get();
            DB::commit();
            return ResponseFormatter::success([
                'transaction' =>  $response,
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
        $trx = TransactionProduct::with('items.product')->where('id', $request->input('id'))->get();
        return ResponseFormatter::success([
            'transaction' =>  $trx,
        ], 'Transaction Stored');
    }

    public function allTrx(Request $request)
    {
        $trx = TransactionProduct::with('items.product')->where('user_id', Auth::user()->id)->get();
        if ($request->input('status') == 'process') {
            $trx = TransactionProduct::with('items.product')->where('user_id', Auth::user()->id)->where('status', 'pending')->orWhere('status', 'process')->latest()->get();
        }
        if ($request->input('status') == 'success') {
            $trx = TransactionProduct::with('items.product')->where('user_id', Auth::user()->id)->where('status', 'success')->orWhere('status', 'canceled')->latest()->get();
        }

        return ResponseFormatter::success([
            'transaction' => $trx,
        ], 'Transaction Stored');
    }

    public function rating(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'trx_id' => ['required']
            ]);

            if ($request->items) {
                foreach ($request->items as $item) {
                    $prod = TransactionProductItem::find($item['item']);
                    $prod->update(['rating' => $item['rating']]);
                }
            }

            $response = TransactionProduct::with('items')->where('id', $request->trx_id)->first();
            DB::commit();
            return ResponseFormatter::success([
                'transaction' =>  $response,
            ], 'Rating Stored');
        } catch (Exception $error) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => 'Shometing went wrong',
                'error' => $error,
            ], 500);
        }
    }
}
