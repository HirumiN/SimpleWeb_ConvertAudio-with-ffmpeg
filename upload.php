<?php
$target_dir = "./uploads/";
$uploadFormat = $_POST["uploadFormat"];
$compressionFormat = $_POST["compressionFormat"];
$message = "";
$downloadButton = "";

if (isset($_POST["submit"])) {
    $target_upload = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $filename = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
    $target_compressed = $target_dir . $filename . "." . $compressionFormat;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_upload)) {
        switch ($compressionFormat) {
            case 'mp3':
                system("ffmpeg -i $target_upload -c:a libmp3lame $target_compressed");
                break;
            case 'wma':
                system("ffmpeg -i $target_upload -c:a wmav2 $target_compressed");
                break;
            case 'flac':
                system("ffmpeg -i $target_upload -c:a flac $target_compressed");
                break;
            case 'ogg':
                system("ffmpeg -i $target_upload -c:a libvorbis $target_compressed");
                break;
            case 'aac':
                system("ffmpeg -i $target_upload -c:a aac $target_compressed");
                break;
            default:
                echo "Unsupported compression format.";
                exit;
        }

        $message = "File berhasil diupload dan diubah menjadi $filename.$compressionFormat.";

        // Hapus file asli yang diupload
        unlink($target_upload);

        // Set tombol download
        $downloadButton = '<a href="' . $target_compressed . '" download>
                            <button style="background-color: #007BFF; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                                Download Hasil Konversi
                            </button>
                        </a>';
    } else {
        $message = "Gagal mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Upload and Convert Audio File</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        header {
            background: linear-gradient(90deg, #007BFF, #00FFA1);
            /* Gradient background */
            color: #fff;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-family: 'Lobster', sans-serif;
            font-size: 40px;
            font-weight: bold;
            margin: 0;
            color: #fff;
            background: linear-gradient(90deg, #007BFF, #00FFA1); /* Same gradient as background */
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: linear-gradient(90deg, #fff, #f2f2f2); /* Gradient background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .decoration {
            border-top: 1px solid #ccc;
            margin-top: 40px; /* Menyesuaikan margin-top */
            padding-top: 10px;
            color: #555;
            font-size: 18px;
            line-height: 1.6;
            background: linear-gradient(90deg, #ffcccc, #ff9999);
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Yonvert</h1>
    </header>
    <div class="container">
        <h2> Convert Audio File</h2>
        <!-- Pesan dan Tombol Download -->
        <div>
            <?php echo $message; ?>
            <?php echo $downloadButton; ?>
        </div>
    </div>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <a href="index.html" style="text-decoration: none;">
            <button style="background-color: #007BFF; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                Kembali ke Index
            </button>
        </a>
    </div>
    <div class="decoration">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
</body>
</html>