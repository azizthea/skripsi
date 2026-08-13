<?php
$src = "C:\\Users\\Lenovo\\.gemini\\antigravity\\brain\\060215e9-d23f-4948-92d1-26d10457b036\\media__1776505805182.png";
$destDir = "public/images";
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}
$dest = $destDir . "/logo.png";

$data = file_get_contents($src);
if (!$data) {
    die("Failed to read image file.");
}
$img = @imagecreatefromstring($data);
if (!$img) {
    die("Failed to parse image file format.");
}

$width = imagesx($img);
$height = imagesy($img);

$out = imagecreatetruecolor($width, $height);
imagesavealpha($out, true);
imagealphablending($out, false);
$transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
imagefill($out, 0, 0, $transparent);

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        $rgb = imagecolorat($img, $x, $y);
        $colors = imagecolorsforindex($img, $rgb);
        $r = $colors['red'];
        $g = $colors['green'];
        $b = $colors['blue'];
        $a = isset($colors['alpha']) ? $colors['alpha'] : 0;
        
        // Define white as > 230
        if ($r > 230 && $g > 230 && $b > 230) {
            imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, 255, 255, 255, 127));
        } else {
            imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $r, $g, $b, $a));
        }
    }
}

imagepng($out, $dest);
imagedestroy($img);
imagedestroy($out);
echo "Success\n";
