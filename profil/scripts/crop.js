let cropper;
const fileInput = document.getElementById('fileInput');
const image = document.getElementById('image');
const preview = document.getElementById('preview');

fileInput.addEventListener('change', (event) => {
    const files = event.target.files;
    const done = (url) => {
        image.src = url;
        image.style.display = 'block';
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            preview: preview,
        });
    };
    let reader;
    let file;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = (e) => {
                done(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

document.getElementById('cropButton').addEventListener('click', () => {
    const canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    });
    preview.innerHTML = '';
    preview.appendChild(canvas);

    canvas.toBlob((blob) => {
        const formData = new FormData();
        formData.append('croppedImage', blob, 'cropped.jpg');

        fetch('upload_image.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            window.location.href = 'profilforme.php';
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Upload failed');
        });
    }, 'image/jpeg');
});