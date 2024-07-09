<?php
if (isset($_GET['category'])) {
    $category = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['category']);
    $dir = "../uploads/{$category}";

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Category already exists.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Category name is required.']);
}
?>
