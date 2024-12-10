<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TransactionProduct;

class TrxProductController extends Controller
{
    public function index()
    {
        $transactions = TransactionProduct::with('items')->where('status', 'pending')->orWhere('status', 'process')->latest()->get();
        $data = [
            'total_pesanan' => TransactionProduct::count(),
            'proses' => TransactionProduct::where('status', 'pending')->orWhere('status', 'process')->count(),
            'success' => TransactionProduct::where('status', 'success')->count(),
            'today' => TransactionProduct::whereDate('created_at', Carbon::today())->count(),
        ];
        return view('retail.dashboard', compact('transactions', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:process,canceled,success',
        ]);

        $transaction = TransactionProduct::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();
        if ($request->status == 'process') {
            foreach ($transaction->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stok -= $item->kuantitas;
                    $product->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }

    public function riwayat()
    {
        $transactions = TransactionProduct::with('items')->where('status', 'success')->orWhere('status', 'canceled')->get();
        return view('retail.transaction.index', compact('transactions'));
    }
}
