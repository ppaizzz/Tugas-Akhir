import os, zipfile, xml.etree.ElementTree as ET

os.makedirs('.gemini/scratch', exist_ok=True)
z = zipfile.ZipFile(r'd:\Faizz\Doc\TEA\KO BANANYO\TugasAkhir\Sistem Informasi Penjualan.docx')
root = ET.fromstring(z.read('word/document.xml'))
ns = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}
paras = root.findall('.//w:p', ns)
out = []
for p in paras:
    texts = [node.text for node in p.findall('.//w:t', ns) if node.text]
    out.append(''.join(texts))
with open('.gemini/scratch/docx.txt', 'w', encoding='utf-8') as f:
    f.write('\n'.join(out))
