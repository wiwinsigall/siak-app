<?php
// php dup_summary.php phpcpd.xml app/Http/Controllers
if ($argc < 3) {
    echo "Usage: php dup_summary.php <phpcpd.xml> <targetDir>\n";
    exit(1);
}
[$script, $xmlFile, $targetDir] = $argv;
$targetDir = realpath($targetDir);

$loc  = [];        // total baris per file
$dup  = [];        // baris duplikat per file

// hitung LOC tiap controller
foreach (glob($targetDir . '/*.php') as $file) {
    $loc[$file] = count(file($file, FILE_SKIP_EMPTY_LINES));
}

// baca hasil phpcpd
$xml = simplexml_load_file($xmlFile);
foreach ($xml->duplication as $d) {
    $lines = (int)$d['lines'];
    foreach ($d->file as $f) {
        $path = (string)$f['path'];
        if (isset($loc[$path])) {
            $dup[$path] = ($dup[$path] ?? 0) + $lines;
        }
    }
}

// cetak tabel
printf("%-3s %-25s %-10s %-10s\n", 'No', 'Nama Controller', 'LOC', '% Dup');
$i = 1;
$totLoc = 0;
$totDup = 0;
foreach ($loc as $file => $nloc) {
    $ndup = $dup[$file] ?? 0;
    $pct  = $nloc ? ($ndup * 100 / $nloc) : 0;
    printf(
        "%-3d %-25s %-10d %6.2f%%\n",
        $i++,
        basename($file),
        $nloc,
        $pct
    );
    $totLoc += $nloc;
    $totDup += $ndup;
}
printf(
    "%-29s %-10d %6.2f%%\n",
    'Total',
    $totLoc,
    $totLoc ? $totDup * 100 / $totLoc : 0
);
