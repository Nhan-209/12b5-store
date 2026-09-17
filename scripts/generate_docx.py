import os
import zipfile
import xml.sax.saxutils as saxutils

def escape_xml(text):
    return saxutils.escape(text)

def create_docx_from_markdown(md_path, docx_path):
    print(f"Reading markdown from: {md_path}")
    with open(md_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()

    doc_body_xml = []

    # Title & Cover styling
    for line in lines:
        raw = line.rstrip('\r\n')
        stripped = raw.strip()
        if not stripped:
            continue

        if stripped.startswith('# '):
            text = escape_xml(stripped[2:])
            doc_body_xml.append(f"""
            <w:p>
                <w:pPr>
                    <w:pStyle w:val="Title"/>
                    <w:jc w:val="center"/>
                    <w:spacing w:before="240" w:after="240"/>
                </w:pPr>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:b/>
                        <w:color w:val="0F172A"/>
                        <w:sz w:val="40"/>
                    </w:rPr>
                    <w:t>{text}</w:t>
                </w:r>
            </w:p>
            """)
        elif stripped.startswith('## '):
            text = escape_xml(stripped[3:])
            doc_body_xml.append(f"""
            <w:p>
                <w:pPr>
                    <w:pStyle w:val="Heading1"/>
                    <w:spacing w:before="300" w:after="120"/>
                </w:pPr>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:b/>
                        <w:color w:val="1E3A8A"/>
                        <w:sz w:val="32"/>
                    </w:rPr>
                    <w:t>{text}</w:t>
                </w:r>
            </w:p>
            """)
        elif stripped.startswith('### '):
            text = escape_xml(stripped[4:])
            doc_body_xml.append(f"""
            <w:p>
                <w:pPr>
                    <w:pStyle w:val="Heading2"/>
                    <w:spacing w:before="200" w:after="80"/>
                </w:pPr>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:b/>
                        <w:color w:val="2563EB"/>
                        <w:sz w:val="26"/>
                    </w:rPr>
                    <w:t>{text}</w:t>
                </w:r>
            </w:p>
            """)
        elif stripped.startswith('- '):
            text = escape_xml(stripped[2:])
            doc_body_xml.append(f"""
            <w:p>
                <w:pPr>
                    <w:ind w:left="400"/>
                    <w:spacing w:before="40" w:after="40"/>
                </w:pPr>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>• {text}</w:t>
                </w:r>
            </w:p>
            """)
        elif stripped.startswith('|') and stripped.endswith('|'):
            # Table row
            cols = [c.strip() for c in stripped.strip('|').split('|')]
            if any(set(c) == {'-'} or '---' in c for c in cols):
                continue
            cells_xml = []
            for col in cols:
                cell_text = escape_xml(col)
                cells_xml.append(f"""
                <w:tc>
                    <w:tcPr>
                        <w:tcW w:w="2400" w:type="dxa"/>
                        <w:tcBorders>
                            <w:top w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>
                            <w:bottom w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>
                        </w:tcBorders>
                    </w:tcPr>
                    <w:p>
                        <w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>
                        <w:r>
                            <w:rPr>
                                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                                <w:sz w:val="22"/>
                            </w:rPr>
                            <w:t>{cell_text}</w:t>
                        </w:r>
                    </w:p>
                </w:tc>
                """)
            doc_body_xml.append(f"""
            <w:tbl>
                <w:tblPr>
                    <w:tblW w:w="9600" w:type="dxa"/>
                    <w:jc w:val="center"/>
                </w:tblPr>
                <w:tr>{''.join(cells_xml)}</w:tr>
            </w:tbl>
            """)
        else:
            text = escape_xml(stripped)
            doc_body_xml.append(f"""
            <w:p>
                <w:pPr>
                    <w:jc w:val="both"/>
                    <w:spacing w:line="360" w:lineRule="auto" w:after="100"/>
                </w:pPr>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="26"/>
                    </w:rPr>
                    <w:t>{text}</w:t>
                </w:r>
            </w:p>
            """)

    content_types_xml = """<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
        <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
        <Default Extension="xml" ContentType="application/xml"/>
        <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
    </Types>"""

    rels_xml = """<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
        <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
    </Relationships>"""

    document_xml = f"""<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
        <w:body>
            {''.join(doc_body_xml)}
            <w:sectPr>
                <w:pgSz w:w="11906" w:h="16838"/>
                <w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/>
            </w:sectPr>
        </w:body>
    </w:document>"""

    print(f"Creating docx at: {docx_path}")
    with zipfile.ZipFile(docx_path, 'w', zipfile.ZIP_DEFLATED) as docx:
        docx.writestr('[Content_Types].xml', content_types_xml)
        docx.writestr('_rels/.rels', rels_xml)
        docx.writestr('word/document.xml', document_xml)

    print("DOCX file generated successfully!")

if __name__ == '__main__':
    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    md_file = os.path.join(base_dir, 'Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md')
    docx_file = os.path.join(base_dir, 'Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx')
    create_docx_from_markdown(md_file, docx_file)
