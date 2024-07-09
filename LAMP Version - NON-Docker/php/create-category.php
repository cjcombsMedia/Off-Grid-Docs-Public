<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$category = $data['category'] ?? '';
if (empty($category)) {
    echo json_encode(['success' => false, 'message' => 'Category name is required.']);
    exit;
}

$categoryDir = __DIR__ . '/../categories/' . $category;
$uploadsDir = __DIR__ . '/../uploads/' . $category;
$categoryHtml = $categoryDir . '/' . $category . '.html';

if (!is_dir($categoryDir)) {
    mkdir($categoryDir, 0777, true);
    mkdir($uploadsDir, 0777, true);
}

$htmlContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$category - Project Raptor</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>$category</h1>
            <input type="text" id="search-input" placeholder="Search files...">
            <button onclick="searchFiles()">Search</button>
        </header>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="survival.html">Survival</a></li>
                <li><a href="automotive.html">Automotive</a></li>
                <li><a href="fishing.html">Fishing</a></li>
                <li><a href="misc.html">Misc</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>$category Files</h2>
                <ul id="file-list">
                    <!-- $category files will be listed here -->
                </ul>
            </section>
            <section id="search-results" style="display:none;">
                <h2>Search Results</h2>
                <ul id="search-list">
                    <!-- Search results will be listed here -->
                </ul>
            </section>
        </main>
        <button id="theme-toggle">Toggle Theme</button>
    </div>
    <script src="../script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
            }
            fetchFiles('$category');
        });
    </script>
</body>
</html>
HTML;

file_put_contents($categoryHtml, $htmlContent);

echo json_encode(['success' => true]);
?>
