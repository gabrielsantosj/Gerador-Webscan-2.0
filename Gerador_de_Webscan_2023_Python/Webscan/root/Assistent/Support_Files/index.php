<?php
    $base_path = explode("/",getcwd());
    $scene = $base_path[sizeof($base_path)-1];
    $module = prev($base_path);
    
    if(!isset($_GET['config'])){
        header("location: index.php?config=$scene.json");
    }
    
    //IDENTIFICAR CENA
    $scenes_list = fopen("../../ScansData.txt","r");
    $yaw = 0; $pitch = 0;
    if ($scenes_list) {
        while (($line = fgets($scenes_list)) !== false) {
            $coord = explode("=", $line);
            if($coord[0] == $scene) {
                if(isset($_COOKIE["saved_position_pitch"])){
                    $pitch = $_COOKIE["saved_position_pitch"];
                    $yaw = $_COOKIE["saved_position_yaw"];
                }else{
                    $yaw = trim($coord[2]);
                }
                echo "<script> window.localStorage.setItem('coord', '".trim($coord[1])."'); </script>";
            }
        }
        fclose($scenes_list);
    }
    
    $image_name = glob('*.{jpg,JPG}',GLOB_BRACE);
    
    $files = glob("hotspots/*.json");
    if(count($files)>0){
        $fp = fopen($scene.".json","w");
        fwrite($fp,'{ "default": { "firstScene": "'.$scene.'", "autoLoad": true, "hotSpotDebug": false }, "scenes": { "'.$scene.'": { "title": "'.$scene.'", "type": "equirectangular", "panorama": "'.$image_name[0].'", "yaw": '.$yaw.', "pitch": '.$pitch.', "hfov": 120, "autoload": true,
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
                if($first_count == count($files)){
                    $comments = glob("hotspots/comments/*.json");
                    if(count($comments)>0){
                        fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" },');
                        $count_comments = 0;
                        foreach($comments as $comment) {
                            $count_comments++;
                            $str = file_get_contents($comment);
                            $data = json_decode($str, true);
                            $text = $data['text']; $pitch = $data['pitch']; $yaw = $data['yaw']; $id = $data['id']; @$description = $data['description'];
                            if($count_comments == count($comments)){
                                fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "info", "text": "'.$text.'", "id":"'.$id.'", "description": "'.$description.'" }');
                            }else{
                                fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "info", "text": "'.$text.'", "id":"'.$id.'", "description": "'.$description.'" },');
                            }
                        }
                    }else{
                        fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" }');
                    }
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
        <div class="mask"></div>
        <div class="new_annotation">
            <input type="hidden" class="new_annotation_pitch" value="">
            <input type="hidden" class="new_annotation_yaw" value="">
            <div class="new_annotation_header">
                <p>Novo Comentário<span>x</span></p>
            </div>
            <div class="new_annotation_content">
                <p style="color:red;">Não são permitidos caracteres especiais!</p>
                <label for="comment_text">Comentário</label>
                <input type="text" name="comment_text" id="comment_text">
                <label for="comment_description">Descrição (Opcional)</label>
                <textarea name="comment_description" rows="5" id="comment_description"></textarea>
                <button class="new_annotation_button">Salvar</button>
            </div>
        </div>
        <div class="edit_annotation">
            <input type="hidden" class="edit_annotation_pitch">
            <input type="hidden" class="edit_annotation_yaw">
            <div class="new_annotation_header">
                <p>Editar Comentário<span>x</span></p>
            </div>
            <div class="new_annotation_content">
                <p style="color:red;">Não são permitidos caracteres especiais!</p>
                <label for="comment_text_edit">Comentário</label>
                <input type="text" name="comment_text_edit" id="comment_text_edit">
                <label for="comment_description_edit">Descrição (Opcional)</label>
                <textarea name="comment_description_edit" rows="5" id="comment_description_edit"></textarea>
                <a onclick='delete_comment()' style="color:red;">Excluir comentário</a><br><br>
                <button class="update_annotation_button">Salvar Alterações</button>
            </div>
        </div>
        <div class="annotations_switcher">
            <h6>Camadas</h6><br>
            <div class="checkboxes">
                <input type="checkbox" id="scenes" name="scenes" checked />
                <label for="scenes">Cenas</label><br>
                <input type="checkbox" id="comments" name="comments" checked />
                <label for="comments">Comentários</label>
            </div>
        </div>
        <div class="new_comment_button" alt="Inserir novo comentário" title="Inserir novo comentário">+</div>
        <noscript>
           <div class="pnlm-info-box">
              <p>O Javascript tem que estar habilitado para ver esta imagem panoramica.</p>
            </div>
        </noscript>
    </div>
    <script>
        hotSpotDebug = false;
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
        function edit_comment(title, description, comment_id, pitch, yaw){
            $(".edit_annotation").attr('id', comment_id);
            $("#comment_text_edit").val(title);
            $("#comment_description_edit").text(description);
            $(".edit_annotation_pitch").val(pitch);
            $(".edit_annotation_yaw").val(yaw);
            $(".edit_annotation,.mask").show();
        }
        function delete_comment(){
            var id = $(".edit_annotation").attr('id'); var title = $("#comment_text_edit").val();
            if(confirm("Você tem certeza que deseja remover o comentário '"+title+"'?\nEssa ação não pode ser desfeita.")){
                $.ajax({
                    url: 'hotspots/data/delete_comment.php',
                    type: 'POST',
                    data: {id:id},
                    success: function(data){
            		    window.location.reload();
                    }
                });
            }
        }
        $(function(){
            $(".new_comment_button").click(function(){
                if(hotSpotDebug == true){
                    $(".pnlm-hotspot-base").show();
                    $(".pnlm-hot-spot-debug-indicator").hide();
                    hotSpotDebug = false;
                }else{
                    $(".pnlm-hotspot-base").hide();
                    $(".pnlm-hot-spot-debug-indicator").show();
                    hotSpotDebug = true;
                }
            });
            $(".update_annotation_button").click(function(){
                var text = $("#comment_text_edit").val(); var description = $("#comment_description_edit").val(); var pitch = $(".edit_annotation_pitch").val(); var yaw = $(".edit_annotation_yaw").val(); var id = $(".edit_annotation").attr('id');
                if(text != ""){
                    $.ajax({
                        url: 'hotspots/data/update_comment.php', 
                        type: 'POST',
                        data: {text:text,description:description,pitch:pitch,yaw:yaw,id:id},
                        success: function(data){
        		            window.location.reload();
                        }
                    });
                }else{
                    alert("O campo comentário é obrigatório!");
                    $("#comment_text").css({"border":"1px solid red"});
                    $("#comment_text").focus();
                }
            });
            $(".new_annotation_button").click(function(){
                var text = $("#comment_text").val(); var description = $("#comment_description").val(); var pitch = $(".new_annotation_pitch").val(); var yaw = $(".new_annotation_yaw").val();
                if(text != ""){
                    $.ajax({
                        url: 'hotspots/data/insert_comment.php', 
                        type: 'POST',
                        data: {text:text,description:description,pitch:pitch,yaw:yaw},
                        success: function(data){
        		            window.location.reload();
                        }
                    });
                }else{
                    alert("O campo comentário é obrigatório!");
                    $("#comment_text").css({"border":"1px solid red"});
                    $("#comment_text").focus();
                }
                
            });
            $(".mask, .new_annotation p span, .edit_annotation p span").click(function(){
                $(".mask, .new_annotation,.edit_annotation").hide();
                $(".pnlm-hotspot-base").show();
                $(".pnlm-hot-spot-debug-indicator").hide();
                hotSpotDebug = false;
            });
            $("#scenes").click(function(){
                $(".pnlm-scene").toggle();
            });
            $("#comments").click(function(){
                $(".pnlm-info").toggle();
            });
        });
        $(document).keyup(function(e){
            if($(".new_annotation,.edit_annotation").is(":hidden")){
    			if(e.keyCode == 32){ //blankspace
    				$(".pnlm-hotspot-base").toggle();
    				console.log("Visibilidade de hotspots alterada!");
    			}
    		}else{
    		    e.preventDefault();
    		}
		});
    </script>
</body>
</html>