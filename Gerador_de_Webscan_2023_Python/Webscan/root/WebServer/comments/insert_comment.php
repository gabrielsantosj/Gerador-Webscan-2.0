<?php
    $full_url = explode("/", $_SERVER["REQUEST_URI"]);
    array_splice($full_url, count($full_url) -2, 2);
    $path = implode("/", $full_url);
    
    $random_name = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
    $arr = array();
    
    $arr["coord_x"] = $_POST['coord_x'];
    $arr["coord_y"] = $_POST['coord_y'];
    $arr["coord_z"] = $_POST['coord_z'];
    $arr["comment"] = $_POST['comment'];
    $arr["details"] = $_POST['details'];
    
    $fp = fopen("".$random_name.".json","wb");
    fwrite($fp,json_encode($arr));
    fclose($fp);
    
    /* ENVIO DE E-MAIL */
    $coord = str_replace(".",",", $_POST['coord_x']).",".str_replace(".",",", $_POST['coord_y']).",".str_replace(".",",", $_POST['coord_z']);
    $url = "https://".$_SERVER["HTTP_HOST"].implode("/", $full_url)."/index.php#".$coord;
    $from = "noreply@webscan3d.com";
    $to = "webscan_comments@webscan3d.com";
    $subject = 'Novo comentário em "'.$full_url[1].'"';
    $message = "<!DOCTYPE html>
    <html>
        <head><title>'.$subject.'</title></head>
        <body>
            <p>Um comentário foi adicionado em uma Nuvem de Pontos do Webscan3D.</p><br><hr/>
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
    echo $random_name;
    /* ------------- */
?>