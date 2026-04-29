<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "TABLE: " . $tableName . "\n";
    $columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM ' . $tableName);
    foreach ($columns as $column) {
        echo "  - " . $column->Field . " (" . $column->Type . ")\n";
    }
}
