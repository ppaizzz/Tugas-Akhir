<?php
$files = [
    'resources/views/adminPusat/barang/index.blade.php',
    'resources/views/adminPusat/permintaan/index.blade.php',
    'resources/views/adminPusat/permintaan/detail.blade.php',
    'resources/views/kepalaCabang/stok/index.blade.php',
    'resources/views/kepalaCabang/permintaan/index.blade.php',
    'resources/views/kepalaCabang/permintaan/create.blade.php',
    'resources/views/kasir/keep/index.blade.php',
    'resources/views/kasir/keep/create.blade.php',
    'resources/views/kasir/pos/index.blade.php',
    'resources/views/kasir/pos/checkout_keep.blade.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    preg_match('/<title>(.*?)<\/title>/', $content, $matches);
    $title = $matches[1] ?? 'App';
    
    $content = preg_replace('/<!DOCTYPE html>.*?<body.*?>\s*<div[^>]*container[^>]*>/is', '', $content);
    $content = preg_replace('/<\/div>\s*<\/body>\s*<\/html>/is', '', $content);
    
    preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $content, $h1Matches);
    $header = strip_tags(trim($h1Matches[1] ?? $title));
    
    $newContent = "@extends('layouts.app')\n@section('title', '$title')\n@section('header', '$header')\n\n@section('content')\n<div class=\"max-w-6xl mx-auto\">\n" . trim($content) . "\n</div>\n@endsection\n";
    
    file_put_contents($file, $newContent);
    echo "Refactored $file\n";
}
