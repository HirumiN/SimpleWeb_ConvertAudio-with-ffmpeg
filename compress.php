<?php
$target_dir = "./uploads/";
$compressionOption = $_POST["compressionOption"];
$qualityOrSize = $_POST["qualityOrSize"];
$message = "";
$downloadButton = "";

if (isset($_POST["submit"])) {
    $target_upload = $target_dir . basename($_FILES["fileToCompress"]["name"]);
    $filename = pathinfo($_FILES["fileToCompress"]["name"], PATHINFO_FILENAME);
    $target_compressed = $target_dir . $filename . "_compressed.mp3"; // Assuming MP3 output

    if (move_uploaded_file($_FILES["fileToCompress"]["tmp_name"], $target_upload)) {
        switch ($compressionOption) {
            case 'quality':
                // Adjust the quality parameter based on user input
                system("ffmpeg -i $target_upload -q:a $qualityOrSize $target_compressed");
                break;
            case 'size':
                // Adjust the target size based on user input
                system("ffmpeg -i $target_upload -b:a $qualityOrSize $target_compressed");
                break;
            default:
                echo "Invalid compression option.";
                exit;
        }

        $message = "File successfully compressed.";

        // Remove the original uploaded file
        unlink($target_upload);

        // Set download button
        $downloadButton = '<a href="' . $target_compressed . '" download>
                            <button style="background-color: #007BFF; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                                Download Compressed File
                            </button>
                        </a>';
    } else {
        $message = "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Compress Audio File</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        header {
            background: linear-gradient(90deg, #007BFF, #00FFA1);
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
            background: linear-gradient(90deg, #007BFF, #00FFA1);
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: linear-gradient(90deg, #fff, #f2f2f2);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            width: calc(100% - 20px);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="file"] {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
        }

        select {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            background-color: #f8f8f8;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        select:hover,
        select:focus {
            border-color: #66afe9;
            box-shadow: 0 0 5px rgba(102, 175, 233, 0.5);
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .decoration {
            border-top: 1px solid #ccc;
            margin-top: 40px;
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
        <h2>Compress Audio File</h2>

        <!-- Display message and download button -->
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
        <!-- Decoration content -->
    </div>
</body>

</html>
