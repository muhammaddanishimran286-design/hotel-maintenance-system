from pypdf import PdfReader
from pathlib import Path
p=Path(r'C:\xampp\htdocs\hotel-maintenance-system\tmp\pdf_template')
page=PdfReader(r'C:\Users\user\Downloads\FYP CSC2854 S1 2026 2027 .pdf').pages[0]
print('images',len(page.images))
for i,img in enumerate(page.images):
    out=p/f'asset-{i}-{img.name}'
    out.write_bytes(img.data)
    print(out)
