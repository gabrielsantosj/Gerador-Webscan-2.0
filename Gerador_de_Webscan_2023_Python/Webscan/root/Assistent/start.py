import os, glob, ntpath, shutil, cv2, webbrowser, math, random, string
from tkinter.filedialog import askopenfilename,askdirectory
from xml.dom import minidom

is_scene = 0
neighbor_distance_limit = 10 # default 10 meters
version = "1.0.4.1"
webscan_version = 2
'''
    LIMPAR ARQUIVOS ANTES DO PTSCONVERSION()
'''
def WebscanVersion():
    global webscan_version
    ws_version = input("Digite 1 para criar um Webscan 1.0 e 2 para criar um Webscan 2.0\n\n")
    if ws_version == "1":
        webscan_version = 1
    else:
        webscan_version = 2
    return PTSConversion()
def PTSConversion():
    # -----
    print("\n-------------------------------")
    print("Bem-vindo ao gerador do Webscan3D [v"+version+"]. Por favor, selecione um arquivo PTS.\nPor padrão usamos arquivos unificados com 15mm. ")
    print("-------------------------------")
    pts_filename = askopenfilename(title='Selecione um arquivo PTS', filetypes=[("Arquivos PTS", ".pts")])
    if pts_filename != "":
        module_dir = os.listdir(r"../WebServer/modules")
        for folder in module_dir:
            if os.path.isdir("../WebServer/modules/"+folder):
                shutil.rmtree("../WebServer/modules/"+folder, ignore_errors=True)
                shutil.rmtree("../WebServer/pointclouds/"+folder, ignore_errors=True)
        if os.path.isfile("../WebServer/modules/ScansData.js"):
            os.remove("../WebServer/modules/ScansData.js")
        pts_filename_split = pts_filename.split('/')
        pts_file_name = os.path.basename(pts_filename)
        print("Aguarde... Estamos convertendo o PTS para LAS")
        os.system("txt2las.exe "+pts_filename+" -ipts -o out.las -parse xyziRGB")
        print("-------------------------------")
        print("Conversão finalizada com sucesso!")
        print("-------------------------------")
        print("Aguarde... Estamos processando sua nuvem de pontos")
        print("-------------------------------")
        os.system("CloudConverter.exe out.las -o ../WebServer/pointclouds/Cloud/ --overwrite")
        print("-------------------------------")
        print("Nuvem processada com sucesso!")
        print("-------------------------------")
        os.remove("out.las")
        ProcessScannerPositions()
    else:
        return print("Operação cancelada pelo usuário.")
def Panoramics():
    if not os.path.exists("../WebServer/modules/Module"):
        os.mkdir("../WebServer/modules/Module")
    global is_scene
    is_scene = input("Digite 1 para usar as panoramicas do SCENE e 2 para usar as panoramicas do CYCLONE.\n\n")
    if is_scene == "1": #SCENE
        print("\n-------------------------------")
        print("Por favor, selecione o diretório das imagens panoramicas")
        print("-------------------------------")
        panoramics_dir = askdirectory(title='Selecione o diretório das imagens panoramicas')
        if panoramics_dir != "":
            shutil.copytree(panoramics_dir, panoramics_dir+'/backup', dirs_exist_ok=True)
            panoramics_total = len(glob.glob(panoramics_dir+"\*.jpg"))
            current_image = 0
            for filename in glob.glob(panoramics_dir+"/*.jpg"):
                current_image += 1
                # NADIR/ZENITH
                print("Aguarde.. Processando imagens panoramicas ["+str(current_image)+"/"+str(panoramics_total)+"]")
                print("-------------------------------")
                os.system('magick.exe '+panoramics_dir+'/'+ntpath.basename(filename)+' -resize 50% '+panoramics_dir+'/'+ntpath.basename(filename)+'')
                im = cv2.imread(panoramics_dir+'/'+ntpath.basename(filename))
                image_width = float(im.shape[1])
                image_height = float(im.shape[0])
                nadir_height = float(image_width/2 - image_height)
                #os.system('magick.exe logo_4.jpg -geometry '+str(image_width)+'x500! logo_5.jpg')
                os.system('magick.exe logo_5.jpg -geometry '+str(image_width)+'x'+str(nadir_height)+'! logo_6.jpg')
                os.system('magick.exe '+panoramics_dir+'/'+ntpath.basename(filename)+' -geometry '+str(image_width)+'x'+str(int(image_height))+'! -quality 100 '+panoramics_dir+'/'+ntpath.basename(filename)+'')
                os.system('magick.exe -gravity south '+panoramics_dir+'/'+ntpath.basename(filename)+' -splice 0x'+str(nadir_height)+' '+panoramics_dir+'/'+ntpath.basename(filename)+'')
                vertical_position = int(im.shape[0]) 
                os.system('composite logo_6.jpg '+panoramics_dir+'/'+ntpath.basename(filename)+' -geometry +0+'+str(image_height)+'! '+panoramics_dir+'/'+ntpath.basename(filename)+'')
                # --------------------- NADIR/ZENITH
                scan_name = ntpath.basename(filename).split(".jpg")
                if not os.path.exists("../WebServer/modules/Module/"+scan_name[0]):
                    os.mkdir("../WebServer/modules/Module/"+scan_name[0])
                try:
                    shutil.copy2(filename,"../WebServer/modules/Module/"+scan_name[0]+"/"+ntpath.basename(filename))
                    os.remove(ntpath.basename(filename))
                except:
                    pass
            print("Renomeando diretórios...")
            print("-------------------------------")
            os.rename("../WebServer/modules/Module","../WebServer/modules/md")
            os.rename("../WebServer/pointclouds/Cloud","../WebServer/pointclouds/md")
            webbrowser.open('http://localhost:8085', new=2)
            return print("Webscan criado com sucesso!")
        else:
            return print("Operação cancelada pelo usuário.")
    elif is_scene == "2":
        print("-------------------------------")
        print("Por favor, selecione o diretório do TruView.")
        print("-------------------------------")
        truview_dir = askdirectory()
        '''
        if truview_dir != "":
            #PERCORRER PASTAS, COPIAR E GIRAR IMAGENS
        else:
            return print("Operação cancelada pelo usuário.")
        '''
    else:
        print("Parâmetro inválido.\n")
        return Panoramics()
def ProcessScannerPositions():
    import_positions = input("Digite 1 para usar o arquivo SWLocation.xml e 2 para usar o TXT do SCENE.\n\n")
    if import_positions == "1":
        print("\nPor favor, selecione o arquivo SWLocation.xml")
        print("-------------------------------")
        swlocation = askopenfilename(title='Selecione o arquivo SWLocation.xml', filetypes=[("Arquivos XML", ".xml")])
        if swlocation != "":
            if os.path.exists("../WebServer/modules/Module"):
                shutil.rmtree('../WebServer/modules/Module', ignore_errors=True)
            print("Aguarde.. Processando posições das imagens panoramicas.")
            print("-------------------------------")
            dom = minidom.parse(swlocation)
            elements = dom.getElementsByTagName('ScanWorld')
            output = open('../WebServer/modules/ScansData.js', 'w')
            output2 = open('../WebServer/modules/ScansData.txt', 'w')
            for element in elements:
                needle = ["(",")"]
                folder_name = element.attributes['dir'].value.split("_")
                shutil.copytree("Support_Files/hotspots", "../WebServer/modules/Module/"+element.attributes['dir'].value+"/hotspots", copy_function = shutil.copy)
                if webscan_version == 1:
                    shutil.copy("Support_Files/index.php", "../WebServer/modules/Module/"+element.attributes['dir'].value+"/index.php")
                else:
                    shutil.copy("Support_Files/index_20.php", "../WebServer/modules/Module/"+element.attributes['dir'].value+"/index.php")
                full_coordinates = element.attributes['translation'].value.replace("(","").replace(")","")
                rotation_angle = float(element.attributes['rotation_angle'].value)
                rotation_axis = element.attributes['rotation_axis'].value.replace("(","").replace(")","").split(',')
                yaw = (90.000 - rotation_angle)
                if rotation_angle >= 0:
                    if float(rotation_axis[2]) >= 0.000:
                        yaw = (90.000 + rotation_angle)
                    else:
                        yaw = (90.000 - rotation_angle)
                    '''
                    if rotation_angle > 90:
                        yaw = (90.000 - rotation_angle) 
                    else:
                        yaw = (90.000 - rotation_angle)
                    '''
                if rotation_angle < 0:
                    print(element.attributes['dir'].value+' - '+str(rotation_axis[2]))
                    if float(rotation_axis[2]) >= 0.000:
                        yaw = (90.000 + rotation_angle)
                    else:
                        yaw = (90.000 - rotation_angle)
                    '''    
                    if rotation_angle >= -22.5: # ou 30
                        print("Maior que -22.5 = "+str(rotation_angle))
                        yaw = (90.000 + rotation_angle) # (rotation_angle - 90)
                    else:
                        print("Menor que -22.5 = "+str(rotation_angle))
                        yaw = (90.000 - rotation_angle) # (rotation_angle - 90)
                    '''
                coordinates = full_coordinates.split(',')
                if webscan_version == 1:
                    output.write("{ var x = "+coordinates[0]+"; var y = "+coordinates[1]+"; var z = "+coordinates[2]+"; let aRoot = viewer.scene.annotations; let _ = new Potree.Annotation({ title: ' "+coordinates[0]+","+coordinates[1]+","+coordinates[2]+" ', position: [x,y,z], cameraPosition: [x,y+1,z], cameraTarget: [x,y-1,z], 'actions': [{ 'icon': Potree.resourcePath + '/icons/goto.svg', 'onclick': function(){ $('body').after( $( '<iframe src=modules/md/"+element.attributes['dir'].value+"/index.php style=border:1px solid #fff; position: absolute; width: 75%; height: 75%; top:0; bottom:0; left:0; right:0; margin: auto; background: #fff; z-index: 998; border-radius: 5px;> </iframe>')); $('body').after( $('<p class=close_f style=position: absolute; height:20px; z-index:3;float: right; right: 5px; top: 0px; color: #fff; z-index:999; font-family: Arial; cursor: pointer; font-size: 14px;> Vista 3D </p>')); $('body').after( $('<p class=tl style=position:absolute;width:300px;text-align:center;z-index:999;color:#fff;font-family:Arial;background:#000;padding:5px;left:0;right:0;margin:auto;>"+element.attributes['dir'].value+" </p>')); $('.close_f').click(function(){ coordinate = window.localStorage.getItem('coord').split(','); viewer.scene.view.lookAt(new THREE.Vector3(coordinate[0], coordinate[1], coordinate[2])); for(let volume of viewer.scene.volumes){viewer.scene.removeVolume(volume);} $('.exitBoxMode').show(); $('.top_nav').hide(); $('.potree_container').css({'top':'-=100px','height':'calc(100% + 100px)'}); let volume = new Potree.Volume();volume.name = 'Visible';volume.scale.set(15, 15, 10);volume.position.set(coordinate[0], coordinate[1], coordinate[2]); volume.clip = true; volume.visible = false; viewer.scene.addVolume(volume); viewer.setClipTask(Potree.ClipTask.SHOW_INSIDE); $('#boxMode').prop('checked', true); $('#potree_annotation_container').hide(); $('.360_images').attr('src', 'assets/Webscan_cenas-360.svg'); scenes_images = false; $('.close_f').hide(); $('iframe').hide(); $('.tl').hide(); }); } }]}); aRoot.add(_); }\n") 
                else:
                    output.write("{ var x = "+coordinates[0]+"; var y = "+coordinates[1]+"; var z = "+coordinates[2]+"; let aRoot = viewer.scene.annotations; let _ = new Potree.Annotation({ title: ' "+coordinates[0]+","+coordinates[1]+","+coordinates[2]+" ', position: [x,y,z], cameraPosition: [x,y+1,z], cameraTarget: [x,y-1,z], 'actions': [{ 'icon': Potree.resourcePath + '/icons/goto.svg', 'onclick': function(){ $('body').after( $( '<iframe src=/image/'+cloud_name+'/"+element.attributes['dir'].value+" style=border:1px solid #fff; position: absolute; width: 75%; height: 75%; top:0; bottom:0; left:0; right:0; margin: auto; background: #fff; z-index: 998; border-radius: 5px;> </iframe>')); $('body').after( $('<p class=close_f style=position: absolute; height:20px; z-index:3;float: right; right: 5px; top: 0px; color: #fff; z-index:999; font-family: Arial; cursor: pointer; font-size: 14px;> Vista 3D </p>')); $('body').after( $('<p class=tl style=position:absolute;width:300px;text-align:center;z-index:999;color:#fff;font-family:Arial;background:#000;padding:5px;left:0;right:0;margin:auto;>"+element.attributes['dir'].value+" </p>')); $('.close_f').click(function(){ coordinate = window.localStorage.getItem('coord').split(','); viewer.scene.view.lookAt(new THREE.Vector3(coordinate[0], coordinate[1], coordinate[2])); for(let volume of viewer.scene.volumes){viewer.scene.removeVolume(volume);} $('.exitBoxMode').show(); $('.top_nav').hide(); $('.potree_container').css({'top':'-=100px','height':'calc(100%)'});  let volume = new Potree.Volume();volume.name = 'Visible';volume.scale.set(15, 15, 10);volume.position.set(coordinate[0], coordinate[1], coordinate[2]); volume.clip = true; volume.visible = false; viewer.scene.addVolume(volume); viewer.setClipTask(Potree.ClipTask.SHOW_INSIDE); $('#boxMode').prop('checked', true); $('#potree_annotation_container').hide(); $('.360_images').attr('src', '../storage/app/public/base/assets/Webscan_cenas-360.svg'); scenes_images = false; $('.close_f').hide(); $('iframe').hide(); $('.tl').hide(); }); } }]}); aRoot.add(_); }\n")     
                output2.write(element.attributes['dir'].value+"="+coordinates[0].strip()+","+coordinates[1].strip()+","+coordinates[2].strip()+"="+str(yaw)+"\n")
                absolute_path = os.path.dirname(swlocation)+"\\"+element.attributes['dir'].value+"\\CubeMapMeta.xml"
                print(absolute_path)
                dom2 = minidom.parse(absolute_path)
                neighbors = dom2.getElementsByTagName('Lgshds:Neighbor')
                print("---------------- [NEIGHBORS CENA '"+element.attributes['dir'].value+"'] -------------------")
                for neighbor in neighbors:
                    x = float(neighbor.attributes['X'].value)
                    y = float(neighbor.attributes['Y'].value)
                    z = float(neighbor.attributes['Z'].value)
                    target_scene_name = neighbor.attributes['Name'].value
                
                    min_z = (-3.00)
                    max_z = (3.00)
                    
                    distance = math.sqrt(((x - 0) ** 2)+((y - 0) ** 2)+((z - 0) ** 2)) #distance = math.sqrt((x ** 2)+(y ** 2))
                    hipotenusa = math.sqrt((x ** 2) + (z ** 2))
                    try:
                        pitch_target = (math.degrees(math.atan(y/hipotenusa)) - 1.30899666) #DEFAULT FOV / 0.6
                    except ZeroDivisionError:
                        pitch_target = (-1.30899666)
                    if distance < neighbor_distance_limit:
                        rand_name = ''.join(random.choices(string.ascii_lowercase, k=5))
                        if x < 0:
                            try:
                                yaw_target = math.degrees(math.atan(z/x)) - (90 - yaw + 1.30899666)
                            except ZeroDivisionError:
                                yaw_target = 0 - (90 - yaw + 1.30899666)
                        else:
                            try:
                                yaw_target = math.degrees(math.atan(z/x)) + (90 + yaw - 1.30899666)
                            except ZeroDivisionError:
                                yaw_target = 0 + (90 + yaw - 1.30899666)
                        output_cena = open('../WebServer/modules/Module/'+element.attributes['dir'].value+'/hotspots/'+rand_name+'.json', 'w')
                        output_cena.write('{"target_name":"'+target_scene_name+'","pitch":"'+str(pitch_target)+'", "yaw": "'+str(yaw_target)+'"}');
                        output_cena.close()
                        print(str(neighbor.attributes['Name'].value)+" | Yaw: "+str(yaw)+" "+str(x)+" - "+str(y)+" - "+str(z)+" | Distance: "+str(distance)+" Pitch: "+str(pitch_target)+" Yaw: "+str(yaw_target)+"")
                        '''
                        if z >= min_z and z <= max_z:
                            rand_name = ''.join(random.choices(string.ascii_lowercase, k=5))
                            if x < 0: 
                                yaw_target = math.degrees(math.atan(z/x)) - (90 - yaw + 1.30899666)
                            else:
                                yaw_target = math.degrees(math.atan(z/x)) + (90 + yaw - 1.30899666)
                            pitch = z
                            output_cena = open('../WebServer/modules/Module/'+folder_name[1]+'_'+folder_name[2]+'/hotspots/'+rand_name+'.json', 'w')
                            output_cena.write('{"target_name":"'+target_scene_name+'","pitch":"'+str(pitch_target)+'", "yaw": "'+str(yaw_target)+'"}');
                            output_cena.close()
                            print(str(neighbor.attributes['Name'].value)+" | Yaw: "+str(yaw)+" "+str(x)+" - "+str(y)+" - "+str(z)+" | Distance: "+str(distance)+" Pitch: "+str(pitch_target)+" Yaw: "+str(yaw_target)+"")
                        '''
            output.close()
            output2.close()
            Panoramics()
        else:
            return print("Operação cancelada pelo usuário.")
    elif import_positions == "2":
        print("Por favor, selecione o arquivo Positions.txt do SCENE")
        print("-------------------------------")
    else:
        print("Parâmetro inválido.\n")
        return ProcessScannerPositions()
# ----------------------------------------------- #
def main():
    WebscanVersion()
    #PTSConversion()
    #ProcessScannerPositions()
    #Panoramics()
if __name__ == "__main__":
    main()
