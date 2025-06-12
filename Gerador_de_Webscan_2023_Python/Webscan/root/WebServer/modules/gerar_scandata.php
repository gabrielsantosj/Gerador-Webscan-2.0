<?php
    $fp = $cenas.'/ScanWorlds.txt';
    $module_info = explode("/", $cenas);
    $modulo = $module_info[0]; 
    $cena = $module_info[1];
    if(strstr($cena, '.', true)){
        explode(".", $cena);
    }
    $conents_arr = file($fp);
    foreach($conents_arr as $key=>$value){
        $conents_arr[$key]  = rtrim($value, "\r");
    }
    /* TRUVIEW CY9 */
    $coordinates = preg_replace("/[^0-9.]/", "", $conents_arr[23]).",".preg_replace("/[^0-9.]/", "", $conents_arr[24]).",".preg_replace("/[^0-9.]/", "", $conents_arr[25]);

    $x_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[23]);
    $y_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[24]);
    $z_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[25]);

    /* TRUVIEW CY7
    $coordinates = preg_replace("/[^0-9.]/", "", $conents_arr[18]).",".preg_replace("/[^0-9.]/", "", $conents_arr[19]).",".preg_replace("/[^0-9.]/", "", $conents_arr[20]);

    $x_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[18]);
    $y_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[19]);
    $z_coordinate = preg_replace("/[^0-9-.]/", "", $conents_arr[20]);
    */

    $text = '{ var x = '.$x_coordinate.'; var y = '.$y_coordinate.'; var z = '.$z_coordinate.'; let aRoot = viewer.scene.annotations; let '.$cena[0].' = new Potree.Annotation({ title: "'.$x_coordinate.','.$y_coordinate.','.$z_coordinate.' ", position: [x,y,z], cameraPosition: [x,y+1,z], cameraTarget: [x,y-1,z], "actions": [{ "icon": Potree.resourcePath + "/icons/goto.svg", "onclick": function(){ $("body").after( $( "<iframe src=modules/'.$modulo.'/'.$cena.'/index.php style=border:1px solid #fff; position: absolute; width: 75%; height: 75%; top:0; bottom:0; left:0; right:0; margin: auto; background: #fff; z-index: 998; border-radius: 5px;> </iframe>")); $("body").after( $("<p class=close_f style=position: absolute; height:20px; z-index:3;float: right; right: 5px; top: 0px; color: #fff; z-index:999; font-family: Arial; cursor: pointer; font-size: 14px;> CLOSE/FECHAR </p>")); $("body").after( $("<p class=tl style=position:absolute;width:300px;text-align:center;z-index:999;color:#fff;font-family:Arial;background:#000;padding:5px;left:0;right:0;margin:auto;> '.$modulo.' ('.$cena.') </p>")); $(".close_f").click(function(){ $(".close_f").hide(); $("iframe").hide(); $(".tl").hide(); }); } }]}); aRoot.add('.$cena[0].'); }';
    $scans_data = fopen("ScansData.js", "a+");
    fwrite($scans_data, $text."\n");
    fclose($scans_data);
?>