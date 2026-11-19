$ErrorActionPreference = 'Stop'

$src = 'C:\Users\LENOVO\CrossDevice\realme C71\storage\Download\Alight_Motion_alightmotionsapps.com_063034.apk'
$outDir = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..\apk-parts'))
New-Item -ItemType Directory -Force -Path $outDir | Out-Null

$nama = [System.IO.Path]::GetFileName($src)
$partSize = 50MB
$buffer = New-Object byte[] (1MB)

$in = [System.IO.File]::OpenRead($src)
$part = 1
$out = [System.IO.File]::Create((Join-Path $outDir "$nama.part$part"))
$written = [long]0

try {
    while (($read = $in.Read($buffer, 0, $buffer.Length)) -gt 0) {
        if (($written + $read) -gt $partSize -and $written -gt 0) {
            $out.Dispose()
            $part++
            $out = [System.IO.File]::Create((Join-Path $outDir "$nama.part$part"))
            $written = 0
        }

        $out.Write($buffer, 0, $read)
        $written += $read
    }
}
finally {
    $in.Dispose()
    $out.Dispose()
}

$hash = (Get-FileHash $src -Algorithm SHA256).Hash.ToLower()
Set-Content -Path (Join-Path $outDir "$nama.sha256") -Value $hash -NoNewline

Get-ChildItem $outDir | Select-Object Name, @{n='MB';e={[math]::Round($_.Length/1MB,1)}} | Format-Table -AutoSize
Write-Output "SHA256=$hash"
