# Konversi file Markdown di folder docs menjadi dokumen Word (.docx) asli.
# Tidak memerlukan pandoc/python/libreoffice; memakai OOXML + System.IO.Compression.

param(
    [string]$Folder = $PSScriptRoot
)

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

function Esc([string]$s) {
    if ($null -eq $s) { return '' }
    return $s.Replace('&', '&amp;').Replace('<', '&lt;').Replace('>', '&gt;').Replace('"', '&quot;').Replace("'", '&apos;')
}

function Run([string]$text, [string]$bold = '', [string]$italic = '', [string]$code = '') {
    $props = ''
    if ($code)   { $props += '<w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/>' }
    if ($bold)   { $props += '<w:b/>' }
    if ($italic) { $props += '<w:i/>' }
    if ($code)   { $props += '<w:shd w:fill="F2F2F2"/>' }
    $rpr = if ($props) { '<w:rPr>' + $props + '</w:rPr>' } else { '' }
    return '<w:r>' + $rpr + '<w:t xml:space="preserve">' + $text + '</w:t></w:r>'
}

function Convert-Inline([string]$s) {
    if ($null -eq $s) { return '' }
    $sb = New-Object System.Text.StringBuilder
    $pattern = '(\*\*[^*]+\*\*|`[^`]+`|!\[[^\]]*\]\([^)]*\)|\[[^\]]+\]\([^)]*\))'
    $idx = 0

    foreach ($m in [regex]::Matches($s, $pattern)) {
        if ($m.Index -gt $idx) {
            [void]$sb.Append((Run (Esc $s.Substring($idx, $m.Index - $idx))))
        }

        $tok = $m.Value
        if ($tok.StartsWith('**')) {
            [void]$sb.Append((Run (Esc $tok.Substring(2, $tok.Length - 4)) -bold '1'))
        }
        elseif ($tok.StartsWith('`')) {
            [void]$sb.Append((Run (Esc $tok.Substring(1, $tok.Length - 2)) -code '1'))
        }
        elseif ($tok.StartsWith('![')) {
            $alt = [regex]::Match($tok, '!\[([^\]]*)\]').Groups[1].Value
            [void]$sb.Append((Run (Esc ('[Gambar: ' + $alt + ']')) -italic '1'))
        }
        else {
            $text = [regex]::Match($tok, '^\[([^\]]+)\]').Groups[1].Value
            [void]$sb.Append((Run (Esc $text)))
        }

        $idx = $m.Index + $m.Length
    }

    if ($idx -lt $s.Length) {
        [void]$sb.Append((Run (Esc $s.Substring($idx))))
    }

    return $sb.ToString()
}

function Para([string]$inline, [string]$style = 'Normal') {
    return '<w:p><w:pPr><w:pStyle w:val="' + $style + '"/></w:pPr>' + $inline + '</w:p>'
}

function Table-Xml([System.Collections.Generic.List[string]]$rows) {
    $sb = New-Object System.Text.StringBuilder
    [void]$sb.Append('<w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/><w:tblBorders>')
    foreach ($edge in @('top', 'left', 'bottom', 'right', 'insideH', 'insideV')) {
        [void]$sb.Append('<w:' + $edge + ' w:val="single" w:sz="4" w:space="0" w:color="999999"/>')
    }
    [void]$sb.Append('</w:tblBorders></w:tblPr>')

    foreach ($baris in $rows) {
        if ($baris -match '^\|[\s:\-|]+\|$') { continue }
        $sel = $baris.Trim() -split '\|' | Where-Object { $_.Trim() -ne '' } | ForEach-Object { $_.Trim() }
        if ($sel.Count -eq 0) { continue }
        [void]$sb.Append('<w:tr>')
        foreach ($cell in $sel) {
            [void]$sb.Append('<w:tc><w:tcPr><w:tcW w:w="2400" w:type="dxa"/></w:tcPr>')
            [void]$sb.Append('<w:p><w:pPr><w:pStyle w:val="TableText"/></w:pPr>' + (Convert-Inline $cell) + '</w:p></w:tc>')
        }
        [void]$sb.Append('</w:tr>')
    }

    [void]$sb.Append('</w:tbl>')
    return $sb.ToString()
}

function Convert-Markdown([string]$markdown) {
    $lines = $markdown -split "`r?`n"
    $body = New-Object System.Text.StringBuilder
    $table = New-Object 'System.Collections.Generic.List[string]'
    $inCode = $false
    $firstH1 = $true

    function Flush-Table {
        if ($table.Count -gt 0) {
            [void]$body.Append((Table-Xml $table))
            $table.Clear()
        }
    }

    foreach ($line in $lines) {
        if ($line -match '^\s*```') {
            Flush-Table
            $inCode = -not $inCode
            continue
        }

        if ($inCode) {
            [void]$body.Append((Para (Run (Esc $line) -code '1') 'Code'))
            continue
        }

        if ($line -match '^\s*\|') {
            $table.Add($line)
            continue
        }
        Flush-Table

        if ($line -match '^####\s+(.*)$') {
            [void]$body.Append((Para (Convert-Inline $Matches[1]) 'Heading3'))
        }
        elseif ($line -match '^###\s+(.*)$') {
            [void]$body.Append((Para (Convert-Inline $Matches[1]) 'Heading2'))
        }
        elseif ($line -match '^##\s+(.*)$') {
            [void]$body.Append((Para (Convert-Inline $Matches[1]) 'Heading1'))
        }
        elseif ($line -match '^#\s+(.*)$') {
            $style = if ($firstH1) { 'Title' } else { 'Heading1' }
            $firstH1 = $false
            [void]$body.Append((Para (Convert-Inline $Matches[1]) $style))
        }
        elseif ($line -match '^\s*-\s+(.*)$') {
            [void]$body.Append((Para ((Run '•  ') + (Convert-Inline $Matches[1])) 'ListBullet'))
        }
        elseif ($line -match '^\s*\d+\.\s+(.*)$') {
            [void]$body.Append((Para (Convert-Inline $Matches[1]) 'ListNumber'))
        }
        elseif ($line -match '^>\s?(.*)$') {
            [void]$body.Append((Para (Convert-Inline $Matches[1]) 'Quote'))
        }
        elseif ($line -match '^\s*---+\s*$' -or $line -match '^\s*\*{3,}\s*$') {
            continue
        }
        elseif ($line.Trim() -eq '') {
            continue
        }
        else {
            [void]$body.Append((Para (Convert-Inline $line)))
        }
    }

    Flush-Table
    return $body.ToString()
}

function Write-ZipText([System.IO.Compression.ZipArchive]$zip, [string]$name, [string]$content) {
    $entry = $zip.CreateEntry($name, [System.IO.Compression.CompressionLevel]::Optimal)
    $stream = $entry.Open()
    $writer = New-Object System.IO.StreamWriter($stream, (New-Object System.Text.UTF8Encoding($false)))
    $writer.Write($content)
    $writer.Dispose()
}

function New-Docx([string]$mdPath, [string]$docxPath, [string]$judul) {
    $md = Get-Content -LiteralPath $mdPath -Raw -Encoding UTF8
    $bodyXml = Convert-Markdown $md

    $contentTypes = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
  <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
  <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
  <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
</Types>
'@

    $rootRels = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>
'@

    $docRels = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
'@

    $styles = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:docDefaults><w:rPrDefault><w:rPr><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:sz w:val="22"/></w:rPr></w:rPrDefault></w:docDefaults>
  <w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:name w:val="Normal"/></w:style>
  <w:style w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:pPr><w:spacing w:after="240"/></w:pPr><w:rPr><w:b/><w:color w:val="0B5E8A"/><w:sz w:val="44"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:pPr><w:keepNext/><w:spacing w:before="240" w:after="120"/></w:pPr><w:rPr><w:b/><w:color w:val="0B5E8A"/><w:sz w:val="32"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:pPr><w:keepNext/><w:spacing w:before="200" w:after="100"/></w:pPr><w:rPr><w:b/><w:color w:val="0785BB"/><w:sz w:val="26"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading3"><w:name w:val="heading 3"/><w:pPr><w:keepNext/><w:spacing w:before="160" w:after="80"/></w:pPr><w:rPr><w:b/><w:sz w:val="24"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="ListBullet"><w:name w:val="List Bullet"/><w:pPr><w:ind w:left="360"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="ListNumber"><w:name w:val="List Number"/><w:pPr><w:ind w:left="360"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="Quote"><w:name w:val="Quote"/><w:pPr><w:ind w:left="360"/></w:pPr><w:rPr><w:i/><w:color w:val="555555"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Code"><w:name w:val="Code"/><w:pPr><w:shd w:fill="F2F2F2"/><w:ind w:left="180"/></w:pPr><w:rPr><w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/><w:sz w:val="18"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="TableText"><w:name w:val="Table Text"/><w:rPr><w:sz w:val="18"/></w:rPr></w:style>
</w:styles>
'@

    $tanggal = (Get-Date).ToUniversalTime().ToString('yyyy-MM-ddTHH\:mm\:ss\Z', [System.Globalization.CultureInfo]::InvariantCulture)
    $core = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' +
        '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" ' +
        'xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" ' +
        'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' +
        '<dc:title>' + (Esc $judul) + '</dc:title><dc:creator>Tim Pengembang</dc:creator>' +
        '<cp:lastModifiedBy>Tim Pengembang</cp:lastModifiedBy>' +
        '<dcterms:created xsi:type="dcterms:W3CDTF">' + $tanggal + '</dcterms:created>' +
        '<dcterms:modified xsi:type="dcterms:W3CDTF">' + $tanggal + '</dcterms:modified>' +
        '</cp:coreProperties>'

    $app = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
  <Application>AKTIVIA Doc Generator</Application>
  <Company>Sekolah</Company>
</Properties>
'@

    $document = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' +
        '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">' +
        '<w:body>' + $bodyXml +
        '<w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1134" w:right="1134" w:bottom="1134" w:left="1134" w:header="708" w:footer="708" w:gutter="0"/></w:sectPr>' +
        '</w:body></w:document>'

    if (Test-Path -LiteralPath $docxPath) { Remove-Item -LiteralPath $docxPath -Force }
    $zip = [System.IO.Compression.ZipFile]::Open($docxPath, [System.IO.Compression.ZipArchiveMode]::Create)
    try {
        Write-ZipText $zip '[Content_Types].xml' $contentTypes
        Write-ZipText $zip '_rels/.rels' $rootRels
        Write-ZipText $zip 'word/_rels/document.xml.rels' $docRels
        Write-ZipText $zip 'word/document.xml' $document
        Write-ZipText $zip 'word/styles.xml' $styles
        Write-ZipText $zip 'docProps/core.xml' $core
        Write-ZipText $zip 'docProps/app.xml' $app
    }
    finally {
        $zip.Dispose()
    }

    $size = (Get-Item -LiteralPath $docxPath).Length
    Write-Output ("Dibuat: " + $docxPath + " (" + $size + " byte)")
}

New-Docx (Join-Path $Folder 'MANUAL.md') (Join-Path $Folder 'AKTIVIA-User-Manual.docx') 'AKTIVIA - User Manual'
New-Docx (Join-Path $Folder 'TECH-DOCS.md') (Join-Path $Folder 'AKTIVIA-Technical-Documentation.docx') 'AKTIVIA - Technical Documentation'
