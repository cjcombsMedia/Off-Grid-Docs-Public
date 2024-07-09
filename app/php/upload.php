<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => 'Invalid request.'];

    $category = $_POST['category'] ?? 'misc'; // Default to 'misc' if not set
    $uploadDir = __DIR__ ."/../uploads/$category/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['file'])) {
        $fileError = $_FILES['file']['error'];
        if ($fileError === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $dest_path = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $response = ['success' => true, 'message' => "File uploaded to $category successfully."];
            } else {
                $response = ['success' => false, 'message' => 'There was an error moving the file to the upload directory.'];
            }
        } else {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
            ];
            $response = ['success' => false, 'message' => $errorMessages[$fileError] ?? 'Unknown error.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'File array is not set or file not uploaded.'];
    }

    error_log($response['message'], 3, 'upload_error.log');
    echo json_encode($response);
}
?>
