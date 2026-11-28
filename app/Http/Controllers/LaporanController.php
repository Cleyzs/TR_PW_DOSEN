<?php

namespace App\Http\Controllers;

use App\Models\TransaksiServis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function ambilData(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ], [
            'dari.date'              => 'Tanggal awal tidak valid.',
            'sampai.date'            => 'Tanggal akhir tidak valid.',
            'sampai.after_or_equal'  => 'Tanggal akhir tidak boleh sebelum tanggal awal.',
        ]);

        $query = TransaksiServis::with('kendaraan.pelanggan')->orderBy('tanggal');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        return $query->get();
    }

    public function index(Request $request)
    {
        $servis = $this->ambilData($request);
        $total  = $servis->sum('total_biaya');

        return view('laporan.index', compact('servis', 'total'));
    }

    public function pdf(Request $request)
    {
        $servis = $this->ambilData($request);
        $total  = $servis->sum('total_biaya');
        $dari   = $request->dari;
        $sampai = $request->sampai;

        $pdf = Pdf::loadView('laporan.pdf', compact('servis', 'total', 'dari', 'sampai'))
            ->setPaper('a4', 'portrait');

        // Buang output liar (warning/spasi) supaya file PDF tidak rusak
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        return $pdf->download('laporan-servis.pdf');
    }
}