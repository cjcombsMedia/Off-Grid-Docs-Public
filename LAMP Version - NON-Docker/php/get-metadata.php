<?php
$metadataPath = '../metadata.json';
$metadata = file_exists($metadataPath) ? json_decode(file_get_contents($metadataPath), true) : [];
echo json_encode($metadata);
?>
