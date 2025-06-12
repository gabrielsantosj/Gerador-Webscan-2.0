<?php
    session_start();
    
    $p = explode("/", $_SERVER["REQUEST_URI"]);
    
    $scene = $_SESSION['scene'];
    $token = $_SESSION['token'];
    $comments = $_SESSION['comments'];
    $webscan_id = $_SESSION['webscan_id'];
    $admin = $_SESSION['admin'];
    $administrator = $_SESSION['administrator'];
    
    //SE O NUMERO DE COMENTÁRIOS NÃO FOR O MESMO 
    
    if(!isset($_SESSION['permissions'])){
        header("HTTP/1.0 404 Not Found");
        exit();
    }

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
        fwrite($fp,'{ "default": { "firstScene": "'.$scene.'", "autoLoad": true, "hotSpotDebug": false }, "scenes": { "'.$scene.'": { "title": "'.$scene.'", "type": "equirectangular", "panorama": "'.$scene.'.jpg", "yaw": '.$yaw.', "pitch": '.$pitch.', "hfov": 120, "autoload": true,
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
                    if(count($comments)>0 && in_array($token." view comments", array_column($_SESSION['permissions'], 'name')) || count($comments)>0 && $administrator == 1 || count($comments)>0 && $admin == 1){
                        fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "../'.$target_name.'/index.php?config='.$target_name.'.json" },');
                        $count_comments = 0;
                        foreach($comments as $comment) {
                            $count_comments++;
                            if($count_comments == count($comments)){
                                fwrite($fp,'{ "pitch": '.$comment['pitch'].', "yaw": '.$comment['yaw'].', "type": "info", "text": '.json_encode($comment['text']).', "id": '.$comment['id'].', "description": '.json_encode($comment['description']).', "status": '.json_encode($comment['status']).' }');
                            }else{
                                fwrite($fp,'{ "pitch": '.$comment['pitch'].', "yaw": '.$comment['yaw'].', "type": "info", "text": '.json_encode($comment['text']).', "id": '.$comment['id'].', "description": '.json_encode($comment['description']).', "status": '.json_encode($comment['status']).' },');
                            }
                            /*
                            $str = file_get_contents($comment);
                            $data = json_decode($str, true);
                            $text = $data['text']; $pitch = $data['pitch']; $yaw = $data['yaw']; $id = $data['id']; @$description = json_encode($data['description']);
                            if($count_comments == count($comments)){
                                fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "info", "text": '.$text.', "id":"'.$id.'", "description": '.$description.' }');
                            }else{
                                fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "info", "text": '.$text.', "id":"'.$id.'", "description": '.$description.' },');
                            }
                            */
                        }
                    }else{
                        fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "/image/'.$token.'/'.$target_name.'/" }');
                    }
                }else{
                    fwrite($fp,'{ "pitch": '.$pitch.', "yaw": '.$yaw.', "type": "scene", "text": "'.$target_name.'", "sceneId": "'.$target_name.'", "URL": "/image/'.$token.'/'.$target_name.'/" },');
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
    <meta http-Equiv="Cache-Control" Content="no-cache" />
    <meta http-Equiv="Pragma" Content="no-cache" />
    <meta http-Equiv="Expires" Content="0" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="/storage/app/public/base/js/jquery.js"></script>
    <link type="text/css" rel="Stylesheet" href="/storage/app/public/base/css/pannellum.css"/>
    <link type="text/css" rel="Stylesheet" href="/storage/app/public/base/css/standalone.css"/>
    <script type="text/javascript" src="/storage/app/public/base/js/libpannellum.js"></script>
    <script type="text/javascript" src="/storage/app/public/base/js/pannellum.js"></script>
    <script type="text/javascript" src="/storage/app/public/base/js/standalone.js"></script>
    <title><?php echo $token; ?></title>
</head>
<body>
    <div id="container">
        <div class="mask"></div>
        <div class="new_annotation">
            <input type="hidden" class="webscan_id" value="<?php echo $webscan_id; ?>">
            <input type="hidden" class="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" class="scene" value="<?php echo $scene; ?>">
            <input type="hidden" class="new_annotation_pitch" value="">
            <input type="hidden" class="new_annotation_yaw" value="">
            <div class="new_annotation_header">
                <p>Novo Comentário<span>x</span></p>
            </div>
            <div class="new_annotation_content">
                <label for="comment_text">Comentário</label>
                <input type="text" name="comment_text" id="comment_text" autocomplete="off">
                <label for="comment_description">Descrição (Opcional)</label>
                <textarea name="comment_description" rows="5" id="comment_description" autocomplete="off"></textarea>
                <label for="comment_status">Status</label>
                <input type="text" name="comment_status" id="comment_status" autocomplete="off">
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
                <label for="comment_text_edit">Comentário</label>
                <input type="text" name="comment_text_edit" id="comment_text_edit" autocomplete="off">
                <label for="comment_description_edit">Descrição (Opcional)</label>
                <textarea name="comment_description_edit" rows="5" id="comment_description_edit" autocomplete="off"></textarea>
                <label for="comment_status_edit">Status</label>
                <input type="text" name="comment_status_edit" id="comment_status_edit" autocomplete="off">
                <a class="delete_comment" onclick='delete_comment()' style="color:red;">Excluir comentário</a><br><br>
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
        <div class="help_comment_modal">
            <div class="head">
                <h3>Inserção de comentários</h3><span class="close">x</span>
            </div>
            <div class="content">
                <h3>Passo 1:</h3>
                <p>Clique no ícone <span class="add_btn">+</span> no topo direito da página.</p>
                <h3>Passo 2:</h3>
                <p>Gire a imagem usando o mouse ou o teclado até posicionar o ícone <span class="add_btn">+</span> no local exato onde deseja inserir o comentário.</p>
                <h3>Passo 3:</h3>
                <p>Aperte a tecla C no teclado e preencha as informações do formulário e depois clique em Salvar.</p>
                <p><b>Você pode acessar este material de ajuda a qualquer momento pressionando a tecla H.<b></p>
            </div>
        </div>
        <div class="new_comment_button" alt="Inserir novo comentário" title="Inserir novo comentário">+</div>
        <noscript>
           <div class="pnlm-info-box">
              <p>O Javascript tem que estar habilitado para ver esta imagem panoramica.</p>
            </div>
        </noscript>
    </div>
    <?php
        if($admin != 1 && $administrator != 1 && $access_token != NULL){
            if (!in_array($token." view comments", array_column($_SESSION['permissions'], 'name'))){
                echo "<script> $('.new_comment_button,.new_annotation,.edit_annotation,.annotations_switcher').remove();</script>";
            }
            if (!in_array($token." create comments", array_column($_SESSION['permissions'], 'name'))){
                echo "<script> $('.new_comment_button,.new_annotation,.edit_annotation').remove(); </script>";
            }
            if (!in_array($token." edit comments", array_column($_SESSION['permissions'], 'name'))){
                echo "<script> $('.edit_annotation').remove(); </script>";
            }
            if (!in_array($token." delete comments", array_column($_SESSION['permissions'], 'name'))){
                echo "<script> $('.delete_comment').remove(); </script>";
            }
        }
    ?>
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
        function edit_comment(title, description, status, comment_id, pitch, yaw){
            $(".edit_annotation").attr('id', comment_id);
            $("#comment_text_edit").val(title);
            $("#comment_description_edit").text(description);
            $("#comment_status_edit").val(status);
            $(".edit_annotation_pitch").val(pitch);
            $(".edit_annotation_yaw").val(yaw);
            $(".edit_annotation,.mask").show();
        }
        function delete_comment(){
            var id = $(".edit_annotation").attr('id'); var title = $("#comment_text_edit").val(); var webscan_id = $(".webscan_id").val();
            if(confirm("Você tem certeza que deseja remover o comentário '"+title+"'?\nEssa ação não pode ser desfeita.")){
                $.ajax({
                    url: '/comments/'+id,
                    type: 'DELETE',
                    data: {id:id,webscan_id:webscan_id},
                    success: function(data){
                        $("body").html(data);
            		    window.location.reload();
                    }
                });
            }
        }
        $(document).keyup(function(e){
            if($(".new_annotation,.edit_annotation,.help_comment_modal").is(":hidden")){
    			if(e.keyCode == 72){ //H
    				$(".help_comment_modal,.mask").show();
    			}
    		}else{
    		    e.preventDefault();
    		}
		});
        $(function(){
            if(window.localStorage.getItem('help_comment_modal')!=1){
                window.localStorage.setItem('help_comment_modal', 1);
                $(".help_comment_modal,.mask").show();
            }
            $(".help_comment_modal .close").click(function(){
                $(".help_comment_modal,.mask").hide(); 
            });
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
                var text = $("#comment_text_edit").val(); var description = $("#comment_description_edit").val(); var status = $("#comment_status_edit").val(); var pitch = $(".edit_annotation_pitch").val(); var yaw = $(".edit_annotation_yaw").val(); var id = $(".edit_annotation").attr('id'); var webscan_id = $(".webscan_id").val(); var user_id = $(".user_id").val();
                if(text != ""){
                    $.ajax({
                        url: '/comments/'+id, 
                        type: 'PUT',
                        data: {text:text,description:description,status:status,pitch:pitch,yaw:yaw,id:id,webscan_id:webscan_id,user_id:user_id},
                        success: function(data){
                            $("body").html(data);
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
                var text = $("#comment_text").val(); var description = $("#comment_description").val(); var status = $("#comment_status").val(); var pitch = $(".new_annotation_pitch").val(); var yaw = $(".new_annotation_yaw").val(); var webscan_id = $(".webscan_id").val(); var user_id = $(".user_id").val(); var coord = window.localStorage.getItem('coord'); var scene = $(".scene").val();
                if(text != ""){
                    $.ajax({
                        url: '/comments', 
                        type: 'POST',
                        data: {text:text,description:description,status:status,pitch:pitch,yaw:yaw,webscan_id:webscan_id,user_id:user_id,coord:coord,scene:scene},
                        success: function(data){
                            $("body").html(data);
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
                $(".mask, .new_annotation,.edit_annotation,.help_comment_modal").hide();
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
    </script>
</body>
</html>