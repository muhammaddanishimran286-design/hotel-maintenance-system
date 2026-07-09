from PIL import Image, ImageOps, ImageDraw
from pathlib import Path
p=Path(r'C:\xampp\htdocs\hotel-maintenance-system\tmp\report_build\docx_render')
files=sorted(p.glob('page-*.png'))
thumbs=[]
for f in files:
    im=Image.open(f).convert('RGB'); im.thumbnail((300,390)); canvas=Image.new('RGB',(320,430),'white'); canvas.paste(im,((320-im.width)//2,20)); ImageDraw.Draw(canvas).text((10,405),f.stem,fill='black'); thumbs.append(canvas)
sheet=Image.new('RGB',(320*4,430*4),'#DDDDDD')
for i,im in enumerate(thumbs): sheet.paste(im,((i%4)*320,(i//4)*430))
sheet.save(p/'contact-sheet.png')
