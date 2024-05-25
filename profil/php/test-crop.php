<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Cropper</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style-main-structure.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="../scripts/crop.js" defer></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        img {
            display: block;
            max-width: 50%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid black;
        }

        #cropButton {
            width: 100px;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <input type="file" id="fileInput">
    <div>
        <img id="image" style="display:none;">
    </div>
    <button id="cropButton">Crop</button>
    <div class="preview" id="preview"></div>

</body>

</html>