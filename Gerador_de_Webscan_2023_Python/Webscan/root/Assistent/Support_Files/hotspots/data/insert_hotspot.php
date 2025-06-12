<?php
    $arr = array();
    
    $random_name = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, 5);
    
    $arr["target_name"] = $_POST['target_name'];
    $arr["pitch"] = $_POST['pitch'];
    $arr["yaw"] = $_POST['yaw'];
    
    $fp = fopen("../".$random_name.".json","wb");
    fwrite($fp,json_encode($arr));
    fclose($fp);
?>