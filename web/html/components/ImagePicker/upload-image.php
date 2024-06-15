<?php
if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    if (isset($image['name'])) {
        $name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $error = $image['error'];
        $size = $image['size'];
        $type = $image['type'];
        $ext = explode('.', $name);
        $ext = strtolower(end($ext));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            if ($error === 0) {
                if ($size <= 1000000) {
                    $new_name = uniqid('', true) . '.' . $ext;
                    $destination = '/var/www/uploads/' . $new_name;
                    move_uploaded_file($tmp_name, $destination);
                    $response = array(
                        'status' => 'success',
                        'file_name' => $new_name
                    );

                    $uploadDir = '/uploads/'; // Chemin relatif vers le répertoire /uploads

                    $imageUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $uploadDir . $new_name;

                    echo json_encode($response);
                } else {
                    echo 'File is too big';
                }
            } else {
                echo 'There was an error uploading the file';
            }
        } else {
            echo 'File type not allowed';
        }
    } else {
        echo 'No file selected';
    }
}
?>