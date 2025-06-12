<?php
    $full_url = explode("/", $_SERVER["REQUEST_URI"]);
    array_splice($full_url, count($full_url) -2, 2);
    $path = implode("/", $full_url);

    $arr = array();
    
    $str = file_get_contents("".$_POST['id'].".json");
    $data = json_decode($str, true);

    $arr["coord_x"] = $data['coord_x'];
    $arr["coord_y"] = $data['coord_y'];
    $arr["coord_z"] = $data['coord_z'];
    $arr["comment"] = $_POST['comment'];
    $arr["details"] = $_POST['details'];
    fclose($fp);
    $filename = $_POST['id'].".json";
    unlink($filename);
    
    $create = fopen("".$_POST['id'].".json","wb");
    fwrite($create,json_encode($arr));
    fclose($create);
    
    $coord = str_replace(".",",", $_POST['coord_x']).",".str_replace(".",",", $_POST['coord_y']).",".str_replace(".",",", $_POST['coord_z']);
    $url = "https://".$_SERVER["HTTP_HOST"].implode("/", $full_url)."/index.php#".$coord;
    $from = "noreply@webscan3d.com";
    $to = "webscan_comments@webscan3d.com";
    $subject = 'Nova atualização em "'.$full_url[1].'"';
    $message = "<!DOCTYPE html>
    <html>
        <head><title>'.$subject.'</title></head>
        <body>
            <p>Um comentário foi atualizado em uma Nuvem de Pontos do Webscan3D.</p><br><hr/>
            <p>Comentário: ".$_POST['comment']."</p>
            <p>Descrição: ".$_POST['details']."</p>
            <p>Caminho: ".$path."</p><hr/><br>
            <p><a href='".$url."' target='_blank'>Clique aqui para acessar o comentário</p>
        </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8"."\r\b";
    $headers .= 'From: '.$to.'' . "\r\n";
    mail($to,$subject,$message, $headers);
?>