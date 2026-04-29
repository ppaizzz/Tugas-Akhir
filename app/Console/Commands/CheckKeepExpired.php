<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KeepItem;
use App\Models\Stok;
use Carbon\Carbon;

class CheckKeepExpired extends Command
{
    protected $signature = 'keep:check-expired';
    protected $description = 'Memeriksa dan membatalkan keep barang yang melewati batas waktu';

    public function handle()
    {
        $expiredKeeps = KeepItem::with('details')
            ->where('status', 'aktif')
            ->where('batas_waktu', '<', Carbon::now())
            ->get();

        foreach ($expiredKeeps as $keep) {
            $keep->status = 'kadaluarsa';
            $keep->save();

            // Kembalikan stok
            foreach ($keep->details as $detail) {
                $stok = Stok::where('cabang_id', $keep->cabang_id)
                            ->where('barang_id', $detail->barang_id)
                            ->first();
                if ($stok) {
                    $stok->jumlah += $detail->jumlah;
                    $stok->save();
                }
            }
        }

        $this->info('Pemeriksaan keep barang selesai. Total expired: ' . $expiredKeeps->count());
    }
}
