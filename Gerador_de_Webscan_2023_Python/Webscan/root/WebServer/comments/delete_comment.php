<?php
    if(isset($_POST['id'])){
        $full_url = explode("/", $_SERVER["REQUEST_URI"]);
        array_splice($full_url, count($full_url) -2, 2);
        $path = implode("/", $full_url);
    
        $comment_path = $_POST['id'].'.json';
        $jsonString = file_get_contents($comment_path);
        $jsonData = json_decode($jsonString, true);
        
        $coord = str_replace(".",",", $jsonData['coord_x']).",".str_replace(".",",", $jsonData['coord_y']).",".str_replace(".",",", $jsonData['coord_z']);
        $url = "https://".$_SERVER["HTTP_HOST"].implode("/", $full_url)."/index.php#".$coord;
        $from = "noreply@webscan3d.com";
        $to = "webscan_comments@webscan3d.com";
        $subject = 'Nova atualização em "'.$full_url[1].'"';
        $message = "<!DOCTYPE html>
        <html>
            <head><title>'.$subject.'</title></head>
            <body>
                <p>Um comentário foi excluído em uma foto do Webscan3D.</p><br><hr/>
                <p>Comentário: ".$jsonData['comment']."</p>
                <p>Descrição: ".$jsonData['details']."</p>
                <p>Caminho: ".$path."</p><hr/><br>
                <p><a href='".$url."' target='_blank'>Clique aqui para acessar a coordenada do comentário excluído.</p>
            </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\b";
        $headers .= 'From: '.$to.'' . "\r\n";
        mail($to,$subject,$message, $headers);
        $filename = $_POST['id'].".json";
        unlink($filename);
    }
?>