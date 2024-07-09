<?php
$metadataFile = 'metadata.json';

if (file_exists($metadataFile)) {
    $metadata = json_decode(file_get_contents($metadataFile), true);
} else {
    $metadata = [];
}

if (isset($_POST['siteTitle'])) {
    $metadata['siteTitle'] = $_POST['siteTitle'];
}
if (isset($_POST['sectionsTitle'])) {
    $metadata['sectionsTitle'] = $_POST['sectionsTitle'];
}

file_put_contents($metadataFile, json_encode($metadata, JSON_PRETTY_PRINT));
echo json_encode(['success' => true]);
?>
