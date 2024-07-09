<?php
function countFilesInDirectory($dir) {
    $fileCount = 0;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile()) {
            $fileCount++;
        }
    }
    return $fileCount;
}

$totalItems = 0;
$categories = array_filter(glob('../uploads/*'), 'is_dir');

foreach ($categories as $category) {
    $totalItems += countFilesInDirectory($category);
}

echo json_encode(['totalItems' => $totalItems]);
?>
