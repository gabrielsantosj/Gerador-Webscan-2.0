<?php
    $uploads_path = "../uploads/";
    $fs = [];
    if(isset($_POST['filename'])){
        unlink($uploads_path.$_POST['filename']);
        $uploads = glob("$uploads_path{*}", GLOB_BRACE);
        if(count($uploads)>0){
            if ($_FILES['file']['size'] < 15*MB){
                move_uploaded_file($_FILES['file']['tmp_name'], $uploads_path.$_FILES['file']['name']);
                $uploads = glob("$uploads_path{*}", GLOB_BRACE);
                if(count($uploads)>0){
                    $diretorio = dir($uploads_path);
                    while($arquivo = $diretorio -> read()){
                        if($arquivo != "." && $arquivo != ".."){
                            array_push($fs,$arquivo);
                        }
                    }
                }
            } 
            echo json_encode($fs);
        }
    }
?>