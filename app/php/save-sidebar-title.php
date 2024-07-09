<?php
if (isset($_GET['title'])) {
    $newTitle = trim($_GET['title']);
    // Here you can save the new title to a file or a database
    // For simplicity, we'll just return success
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No title provided.']);
}
?>
