import glob
import os
import cv2

''' SCRIPT TO TRANSFORM 500X500px IMAGE IN NADIR OR ZENITH '''
'''
os.system('magick.exe logo_m.jpg -rotate 180 logo_m_1.jpg')
os.system('magick.exe logo_m_1.jpg -distort DePolar 0 logo_m_2.jpg')
os.system('magick.exe logo_m_2.jpg -flip logo_m_3.jpg')
os.system('magick.exe logo_m_3.jpg -flop logo_m_4.jpg')
os.system('magick.exe logo_m_4.jpg -geometry 4107x500! logo_m_5.jpg')
os.system('magick.exe logo_m_5.jpg -geometry 4107x204! logo_m_6.jpg')
#---------------------------------------------------------------
'''
for i in glob.glob('../*.jpg'):
    os.system('magick.exe '+i+' -resize 50% '+i+'')
    im = cv2.imread(i)
    image_width = int(im.shape[1])
    nadir_height = int(im.shape[0] * 0.10)
    os.system('magick.exe logo_4.jpg -geometry '+str(image_width)+'x500! logo_5.jpg')
    os.system('magick.exe logo_5.jpg -geometry '+str(image_width)+'x'+str(nadir_height)+'! logo_6.jpg')
    vertical_position = int(im.shape[0] - im.shape[0] * 0.10)
    os.system('composite logo_6.jpg '+i+' -geometry +0+'+str(vertical_position)+' '+i+'')
    print(i+" processada com sucesso!\n")
