<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$js = \App\Models\JenisSurat::all();
foreach($js as $j) {
    echo $j->nama_surat . " -> form: " . ($j->form_isian ?? 'KOSONG') . "\n";
}
