<?php
    if(isset($_POST)){
        $fp = fopen("../modules/position.txt","w");
        fwrite($fp,$_POST['x']."_".$_POST['y']."_".$_POST['z']."_".$_POST['pitch']."_".$_POST['yaw']);
        fclose($fp);
    };
?>