<?php
if (isset($_FILES['logo'])) {
    $file = $_FILES['logo'];
    $uploadDirectory = '../logo/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $filePath = $uploadDirectory . 'logo.png';

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
}
?>
