<?php
$metadataPath = '../metadata.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['key']) && isset($input['value'])) {
        $metadata = file_exists($metadataPath) ? json_decode(file_get_contents($metadataPath), true) : [];
        $metadata[$input['key']] = $input['value'];
        file_put_contents($metadataPath, json_encode($metadata, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
