from PIL import Image, ImageDraw
from pathlib import Path
p=Path(r'C:\xampp\htdocs\hotel-maintenance-system\tmp\report_build\combined_render')
files=sorted(p.glob('page-*.png'))
for batch in range(0,len(files),12):
    sheet=Image.new('RGB',(1200,1540),'#DDDDDD')
    for j,f in enumerate(files[batch:batch+12]):
        im=Image.open(f).convert('RGB'); im.thumbnail((280,350))
        tile=Image.new('RGB',(300,385),'white'); tile.paste(im,((300-im.width)//2,10)); ImageDraw.Draw(tile).text((8,365),f.stem,fill='black')
        sheet.paste(tile,((j%4)*300,(j//4)*385))
    sheet.save(p/f'contact-{batch//12+1}.png')
