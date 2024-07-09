<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Manage Categories</h1>
            <button onclick="window.location.href='index.php'">Back to Home</button>
        </header>
        <main>
            <section>
                <h2>Current Categories</h2>
                <ul id="category-list">
                    <?php
                    $categories = array_filter(glob('uploads/*'), 'is_dir');
                    foreach ($categories as $category) {
                        $categoryName = ucfirst(basename($category));
                        echo "<li>$categoryName <button onclick=\"removeCategory('".basename($category)."')\">Remove</button></li>";
                    }
                    ?>
                </ul>
            </section>
            <section>
                <h2>Add New Category</h2>
                <input type="text" id="new-category-name" placeholder="New category name">
                <button onclick="addNewCategory()">Add Category</button>
            </section>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>
