Add-Type -AssemblyName System.Drawing
$src = "C:\Users\Lenovo\.gemini\antigravity\brain\060215e9-d23f-4948-92d1-26d10457b036\media__1776510619077.png"
$destDir = "d:\tes fluter\laravel_app\public\images"
if (!(Test-Path $destDir)) { New-Item -ItemType Directory -Force -Path $destDir | Out-Null }
$dest = "$destDir\logo.png"

$bmp = New-Object System.Drawing.Bitmap($src)
$transparent = [System.Drawing.Color]::FromArgb(0, 0, 0, 0)
for ($y = 0; $y -lt $bmp.Height; $y++) {
    for ($x = 0; $x -lt $bmp.Width; $x++) {
        $c = $bmp.GetPixel($x, $y)
        if ($c.R -gt 230 -and $c.G -gt 230 -and $c.B -gt 230) {
            $bmp.SetPixel($x, $y, $transparent)
        }
    }
}
$bmp.Save($dest, [System.Drawing.Imaging.ImageFormat]::Png)
$bmp.Dispose()
Write-Host "Processed logo saved."
