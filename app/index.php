<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Raptor - Survival Wiki</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <button id="hamburger" class="hamburger">&#9776;</button>
        <div id="sidebar" class="sidebar">
            <div class="logo-container">
                <?php
                $logoPath = 'logo';
                $logoFiles = array_filter(scandir($logoPath), function ($file) use ($logoPath) {
                    $filePath = $logoPath . '/' . $file;
                    return is_file($filePath) && preg_match('/main-logo\.(jpg|jpeg|png|svg|bmp)$/i', $file);
                });
                $logoFile = !empty($logoFiles) ? array_values($logoFiles)[0] : ''; // Get the first matched file
                ?>
                <img src="logo/<?php echo $logoFile; ?>" alt="Logo" class="logo">
                <span id="edit-logo" class="edit-icon" title="Edit Logo">✎</span>
            </div>
            <h2>
                <span id="sections-title"></span> <!-- Initially empty -->
                <span id="edit-sections-title" class="edit-icon" title="Edit Title">✎</span>
            </h2>
            <button class="add-category-btn" onclick="showAddCategoryModal()">Add Category</button>
            <div id="accordion">
                <!-- Categories will be loaded here dynamically -->
            </div>
        </div>
        <div class="content">
            <header>
                <h1>
                    <span id="site-title"></span> <!-- Initially empty -->
                    <span id="edit-site-title" class="edit-icon" title="Edit Title">✎</span>
                </h1>
            </header>
            <div class="toolbar">
                <h2>Total # of items: <span id="total-items-count"></span></h2>
                <button id="theme-toggle" class="icon-button"><img src="assets/lightmode-icon.svg" alt="Toggle Theme"></button>
            </div>
            <div class="mobile-categories">
                <?php
                $categories = array_filter(glob('uploads/*'), 'is_dir');
                foreach ($categories as $category) {
                    $categoryName = ucfirst(basename($category));
                    echo "<div class='mobile-category' oncontextmenu='showContextMenu(event, \"{$categoryName}\")' ontouchstart='startTouch(event, \"{$categoryName}\")'>
                            <a href='category.php?category=" . basename($category) . "'>$categoryName</a>
                          </div>";
                }
                ?>
            </div>
            <h3 style="text-align: center;">NOTE: All content is sourced from open source intelligence and is to be used for survival purposes and education. NOT to be resold at all.</h3>
            <main id="main-content">
                <div class="info-section">
                    <p>Off-Grid-Docs-OFFICIAL<br>This will be the repo where anyone in the world can pull a version of the Off-Grid-Docs web app and use it to have all of your favorite documents, videos, text files etc and will work on ANY device using Docker, develop it to their needs. See more in the README file.<br>Project Raptor - Off Grid Doc Management (DOCKER VERSION)</p>
                </div>
                <div class="manage-section">
                    <div class="manage-categories">
                        <h2>Manage Categories:</h2>
                        <p>To Add a category, click or tap the button "Add Category" above the list of categories. Then a window will show to add the category.</p>
                        <p>To Edit or Remove a category, right-click or tap and hold on an existing category to either edit or remove. A window will show to either allow you to edit or confirm the removal of a category.</p>
                        <p>Known Items to Resolve:</p>
                        <ul>
                            <li>Clean up UI</li>
                            <li>Improve the Mobility layouts</li>
                            <li>Add additional stats</li>
                            <li>Add right-click to items to remove</li>
                            <li>HYBRID Functionality with Local and Local Database (MySQL) - Exploring</li>
                        </ul>
                    </div>
                    <div class="manage-content">
                        <h2>Manage Content:</h2>
                        <form id="upload-form" action="php/upload.php" method="post" enctype="multipart/form-data">
                            <label for="category-select">Select Category:</label>
                            <select id="category-select" name="category">
                                <?php
                                foreach ($categories as $category) {
                                    $categoryName = ucfirst(basename($category));
                                    echo "<option value='" . basename($category) . "'>$categoryName</option>";
                                }
                                ?>
                            </select>
                            <label for="file-upload">Choose file to upload:</label>
                            <input type="file" id="file-upload" name="file">
                            <input type="submit" value="Upload File">
                        </form>
                        <p>To delete content, right-click on the item and select the delete option.</p>
                    </div>
                </div>
                <iframe id="content-frame" name="content-frame" frameborder="0"></iframe>
            </main>
        </div>
    </div>

    <!-- Context Menu -->
    <div id="context-menu" class="context-menu hidden">
        <div class="context-menu-item" onclick="editCategory()">Edit</div>
        <div class="context-menu-item" onclick="deleteCategory()">Delete</div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddCategoryModal()">&times;</span>
            <h2>Add Category</h2>
            <input type="text" id="new-category-name" placeholder="New category name">
            <button onclick="confirmAddCategory()">Add</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
