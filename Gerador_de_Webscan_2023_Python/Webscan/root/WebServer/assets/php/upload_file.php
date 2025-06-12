<?php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
    setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');

    
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);
    
    $uploads_path = "../uploads/";
    
    if (!empty($_FILES['file'])){
        if ($_FILES['file']['size'] < 15*MB){
            move_uploaded_file($_FILES['file']['tmp_name'], $uploads_path.$_FILES['file']['name']);
            $uploads_path = "assets/uploads/";
            $uploads = glob("$uploads_path{*}", GLOB_BRACE);
            if(count($uploads)>0){
                echo "<table><thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
                </thead><tbody>";
                $diretorio = dir($uploads_path);
                while($arquivo = $diretorio -> read()){
                    if($arquivo != "." && $arquivo != ".."){
                        echo "<tr>
                        <td>$arquivo</td>
                            <td><a href='$uploads_path$arquivo' download><img src='assets/download.svg'></a><img src='assets/delete.svg' class='delete_file' id='$arquivo'></td>
                        </tr>";
                    }
                }
                echo "</tbody></table>";
            }else{
                echo '<p class="no_uploads">Nenhum arquivo encontrado.</p>';
            }
        }  
    }
?>