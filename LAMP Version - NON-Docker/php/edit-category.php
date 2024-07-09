<?php
if (isset($_GET['oldCategory']) && isset($_GET['newCategory'])) {
    $oldCategory = '../uploads/' . $_GET['oldCategory'];
    $newCategory = '../uploads/' . $_GET['newCategory'];

    if (file_exists($oldCategory)) {
        rename($oldCategory, $newCategory);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Old category does not exist.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Category names not provided.']);
}
?>
