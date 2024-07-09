<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($_GET['category']); ?> Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo ucfirst($_GET['category']); ?> Files</h1>
            <button id="theme-toggle">Dark Mode Light Mode</button>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>Files</h2>
                <ul id="file-list">
                    <?php
                    $category = $_GET['category'];
                    $directory = "uploads/$category";
                    $files = array_diff(scandir($directory), array('..', '.'));

                    foreach ($files as $file) {
                        $fileType = pathinfo($file, PATHINFO_EXTENSION);
                        $iconPath = '';

                        switch ($fileType) {
                            case 'pdf':
                                $iconPath = 'assets/pdf_icon.svg';
                                break;
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                                $iconPath = 'assets/image_icon.svg';
                                break;
                            case 'mp4':
                            case 'avi':
                                $iconPath = 'assets/video-icon.svg';
                                break;
                            case 'mp3':
                            case 'wav':
                                $iconPath = 'assets/audio-icon.svg'; // Assuming you have an audio icon
                                break;
                            case 'txt':
                                $iconPath = 'assets/txt_icon.svg';
                                break;
                            case 'map':
                                $iconPath = 'assets/map-icon.svg';
                                break;
                            default:
                                $iconPath = 'assets/default-icon.svg'; // Assuming you have a default icon
                                break;
                        }

                        echo "<li><img src='$iconPath' alt='$fileType icon' style='height: 50px; margin-right: 20px;'><a href='$directory/$file' target='_blank'>$file</a></li>";
                    }
                    ?>
                </ul>
            </section>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>
