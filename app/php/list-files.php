<?php
$category = $_GET['category'] ?? 'misc'; // Default to 'misc' if no category is provided

$uploadDir = __DIR__ . '/../uploads/' . $category;

if (!is_dir($uploadDir)) {
    echo json_encode([]);
    exit;
}

$files = array_diff(scandir($uploadDir), ['.', '..']);
echo json_encode(array_values($files));
?>
