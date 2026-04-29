<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cabang = \App\Models\Branch::first();
if ($cabang) {
    \App\Models\User::whereIn('role', ['kepala_cabang', 'kasir'])->update(['cabang_id' => $cabang->id]);
    echo "Cabang ID updated to " . $cabang->id;
} else {
    echo "No branch found!";
}
