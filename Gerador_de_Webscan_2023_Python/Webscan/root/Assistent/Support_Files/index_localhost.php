<?php
    $base_path = explode("/",getcwd());
    $base_path_2 = explode("\\",getcwd());
    $scene = $base_path_2[sizeof($base_path_2)-1];
    $module = prev($base_path);
    
    if(!isset($_GET['config'])){
        header("location: index.php?config=$scene.json");
    }
    
    //IDENTIFICAR CENA
    $scenes_list = fopen("../../ScansData.txt","r");
    $yaw = 0;
    if ($scenes_list) {
        while (($line = fgets($scenes_list)) !== false) {
            $coord = explode("=", $line);
            if($coord[0] == $scene) {
                $yaw = trim($coord[2]);
                echo "<script> window.localStorage.setItem('coord', '".trim($coord[1])."'); </script>";
            }
        }
        fclose($scenes_list);
    }
    
    $image_name = glob('*.{jpg,JPG}',GLOB_BRACE);
    
    $files = glob("hotspots/*.json");
    if(count($files)>0){
        $fp = fopen($scene.".json","w");
        fwrite($fp,'{ "default": { "firstScene": "'.$scene.'", "autoLoad": true, "hotSpotDebug": false }, "scenes": { "'.$scene.'": { "title": "'.$scene.'", "type": "equirectangular", "panorama": "'.$image_name[0].'", "yaw": '.$yaw.', "hfov": 120, "autoload": true,
            "hotSpots": [');
        $first_count = 0;
        foreach($files as $file) {
            $first_count++;
            $filename = basename($file, '.json');
            $comment_id = basename($file, '.json');
            $str = file_get_contents($file);
            $data = json_decode($str, true);
            $target_name = $data['target_name']; $pitch = $data['pitch']; $yaw = $data['yaw'];
            if(count($files)==1){
                fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" }');
            }else{
                if(count($files) == $first_count){
                    fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" }');    
                }else{
                    fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" },');
                }
            }
        }
        fwrite($fp,"] },");
        $count = 0;
        foreach($files as $file) {
            $count++;
            $str = file_get_contents($file);
            $data = json_decode($str, true);
            $target_name = $data['target_name']; $pitch = $data['pitch']; $yaw = $data['yaw'];
            if($count == count($files)){
                fwrite($fp,'"'.$target_name.'": { "title": "'.$target_name.'", "type":"equirectangular", "panorama": "../'.$target_name.'/'.$target_name.'.jpg" }');
            }else{
                fwrite($fp,'"'.$target_name.'": { "title": "'.$target_name.'", "type":"equirectangular", "panorama": "../'.$target_name.'/'.$target_name.'.jpg" },');
            }
        }    
        fwrite($fp,"} }");
    }else{
        $fp = fopen($scene.".json","w");
        fwrite($fp,'{ "default": { "firstScene": "'.$scene.'", "autoLoad": true, "hotSpotDebug": false }, "scenes": { "'.$scene.'": { "title": "'.$scene.'", "type": "equirectangular", "panorama": "'.$scene.'.jpg", "yaw": '.$yaw.', "hfov": 120, "autoload": true } } }');
    }
    fclose($fp);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../../../js/jquery.js"></script>
    <link type="text/css" rel="Stylesheet" href="../../../css/pannellum.css"/>
    <link type="text/css" rel="Stylesheet" href="../../../css/standalone.css"/>
    <script type="text/javascript" src="../../../js/libpannellum.js"></script>
    <script type="text/javascript" src="../../../js/pannellum.js"></script>
    <script type="text/javascript" src="../../../js/standalone.js"></script>
    <title><?php echo $image_name[0]; ?></title>
</head>
<body>
    <div id="container">
        <noscript>
           <div class="pnlm-info-box">
              <p>O Javascript tem que estar habilitado para ver esta imagem panoramica.</p>
            </div>
        </noscript>
    </div>
    <script>
        function create_hotspot(pitch, yaw, target_name){
            $.ajax({
                url: 'hotspots/data/insert_hotspot.php', 
                type: 'POST',
                data: {target_name:target_name,pitch:pitch,yaw:yaw},
                success: function(data){
		            window.location.reload();
                }
            });
        }
        $(document).keyup(function(e){
			if(e.keyCode == 32){ //blankspace
				$(".pnlm-hotspot-base").toggle();
				console.log("Visibilidade de hotspots alterada!");
			}
		});
    </script>
</body>
</html>