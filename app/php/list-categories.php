<?php
$categories = array_filter(glob('../uploads/*'), 'is_dir');
$result = [];

$categoryIcons = [
    'automotive' => 'app/assets/automotive-icon.svg',
    'combat' => 'app/assets/combat-icon.svg',
    'cooking' => 'app/assets/cooking-icon.svg',
    // Add more categories and their icons here
];

foreach ($categories as $category) {
    $categoryName = ucfirst(basename($category));
    $icon = isset($categoryIcons[basename($category)]) ? $categoryIcons[basename($category)] : 'app/assets/default_icon.svg';
    $files = array_diff(scandir($category), ['.', '..']);
    $filesWithIcons = [];
    
    foreach ($files as $file) {
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
        switch (strtolower($fileExtension)) {
            case 'pdf':
                $fileIcon = 'app/assets/pdf_icon.svg';
                break;
            case 'txt':
                $fileIcon = 'app/assets/txt_icon.svg';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $fileIcon = 'app/assets/image_icon.svg';
                break;
            case 'mp4':
            case 'avi':
            case 'mkv':
                $fileIcon = 'app/assets/video-icon.svg';
                break;
            case 'map':
                $fileIcon = 'app/assets/map-icon.svg';
                break;
            default:
                $fileIcon = 'app/assets/default_icon.svg';
        }
        $filesWithIcons[] = ['name' => $file, 'icon' => $fileIcon];
    }
    
    $result[] = ['name' => $categoryName, 'icon' => $icon, 'files' => $filesWithIcons];
}

echo json_encode($result);
