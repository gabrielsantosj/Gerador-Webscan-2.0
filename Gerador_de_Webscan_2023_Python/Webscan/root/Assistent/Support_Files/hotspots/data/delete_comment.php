<?php
    if(isset($_POST['id'])){
        $full_url = explode("/", $_SERVER["REQUEST_URI"]);
        array_splice($full_url, count($full_url) -3, 3);
        $url = "https://".$_SERVER["HTTP_HOST"].implode("/", $full_url);
        
        $path = implode("/", array_slice($full_url, 0, count($full_url) - 3));
    
        $comment_path = '../comments/'.$_POST['id'].'.json';
        $jsonString = file_get_contents($comment_path);
        $jsonData = json_decode($jsonString, true);
        $from = "noreply@webscan3d.com";
        $to = "webscan_comments@webscan3d.com";
        $subject = 'Nova atualização em "'.$full_url[1].'"';
        $message = "<!DOCTYPE html>
        <html>
            <head><title>'.$subject.'</title></head>
            <body>
                <p>Um comentário foi excluído em uma foto do Webscan3D.</p><br><hr/>
                <p>Comentário: ".$jsonData['text']."</p>
                <p>Descrição: ".$jsonData['description']."</p>
                <p>Caminho: ".$path."</p><hr/><br>
                <p><a href='".$url."' target='_blank'>Clique aqui para acessar a imagem 360º</p>
            </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\b";
        $headers .= 'From: '.$to.'' . "\r\n";
        mail($to,$subject,$message, $headers);
        unlink('../comments/'.$_POST['id'].'.json');
    }
?>