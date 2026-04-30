<?php
require __DIR__.'/vendor/autoload.php';

try {
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml('<h1>Test</h1>');
    $dompdf->render();
    $output = $dompdf->output();
    echo "Length of PDF: " . strlen($output) . " bytes\n";
    if (strlen($output) === 0) {
        echo "DomPDF generated 0 bytes!\n";
    } else {
        echo "DomPDF successfully generated data.\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
} catch (\Error $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
}
