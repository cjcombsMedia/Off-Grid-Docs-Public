<?php
if (isset($_GET['category'])) {
    $category = '../uploads/' . $_GET['category'];
    $archiveDir = '../archive/' . $_GET['category'];

    if (file_exists($category)) {
        if (!file_exists('../archive')) {
            mkdir('../archive', 0777, true);
        }

        if (rename($category, $archiveDir)) {
            error_log("Category moved to archive: $category");
            echo json_encode(['success' => true]);
        } else {
            error_log("Failed to move category: $category");
            echo json_encode(['success' => false, 'message' => 'Failed to move category.']);
        }
    } else {
        error_log("Category does not exist: $category");
        echo json_encode(['success' => false, 'message' => 'Category does not exist.']);
    }
} else {
    error_log("Category name not provided.");
    echo json_encode(['success' => false, 'message' => 'Category name not provided.']);
}
?>
