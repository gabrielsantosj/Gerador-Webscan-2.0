<?php
    if (!empty($_POST['base64data'])) {
        $image = explode('base64,', $_POST['base64data']); 
        file_put_contents('../modules/Tumbnail.png', base64_decode($image[1]));
    }
?>