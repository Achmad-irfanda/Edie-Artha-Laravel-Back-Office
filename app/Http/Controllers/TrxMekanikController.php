<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use App\Models\TransactionWorkshop;

class TrxMekanikController extends Controller
{
    public function dashboard()
    {
        $data = [
            'total_pesanan' => TransactionWorkshop::count(),
            'proses' => TransactionWorkshop::where('status', 'pending')->orWhere('status', 'process')->count(),
            'success' => TransactionWorkshop::where('status', 'success')->count(),
            'today' => TransactionWorkshop::whereDate('created_at', Carbon::today())->count(),
        ];
        $transactions = TransactionWorkshop::where('status', 'pending')->orWhere('status', 'process')->latest()->get();
        $mekanik = Mekanik::all();
        return view('bengkel.dashboard', compact('transactions', 'mekanik', 'data'));
    }

    public function update(Request $request)
    {
        $trx = TransactionWorkshop::find($request->id);
        $trx->update([
            'mekanik_id' => $request->mekanik,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Transaksi Diterima!');
    }

    public function riwayat()
    {
        $transactions = TransactionWorkshop::where('status', 'canceled')->orWhere('status', 'success')->get();
        return view('bengkel.transaction.index', compact('transactions'));
    }
}
