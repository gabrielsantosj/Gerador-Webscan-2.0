<?
    if($_POST){
        setcookie("saved_position_pitch", number_format($_POST["pitch"], 2, '.', ''), time() + 3600 * 24 * 365, "/");
        setcookie("saved_position_yaw", number_format($_POST["yaw"], 2, '.', ''), time() + 3600 * 24 * 365, "/");
    }
?>