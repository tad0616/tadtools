<?php
namespace XoopsModules\Tadtools;

class Captcha
{
    public static function prime($length = 8)
    {
        // prime() : step 1, generates a random string and put into session
        // PARAM $length : number of characters for the captcha string

        $char = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $max = strlen($char) - 1;
        $random = "";
        for ($i = 0; $i <= $length; $i++) {
            $random .= substr($char, rand(0, $max), 1);
        }
        $_SESSION['captcha'] = $random;
        return true;
    }

    public static function draw($width = 150, $height = 30, $fontsize = 20, $font = "fonts/teen.ttf")
    {
        // draw() : step 2, generates the captcha image
        // PARAM $width, $height : width and height of the captcha
        //       $font : ! CHANGE THIS TO YOUR OWN !

        // CREATE BLANK IMAGE
        $captcha = imagecreatetruecolor($width, $height);
        if (isset($_SESSION['captcha'])) {
            // FUNKY BACKGROUND IMAGE
            $background = "captcha-back.jpg";
            list($bx, $by) = getimagesize($background);
            if ($bx - $width < 0) {$bx = 0;} else { $bx = rand(0, $bx - $width);}
            if ($by - $height < 0) {$by = 0;} else { $by = rand(0, $by - $height);}
            $background = imagecreatefromjpeg($background);
            imagecopy($captcha, $background, 0, 0, $bx, $by, $width, $height);

            // THE TEXT SIZE
            $text_size = imagettfbbox($fontsize, 0, $font, $_SESSION['captcha']);
            $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
            $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

            // CENTERING THE TEXT BLOCK
            $centerX = CEIL(($width - $text_width) / 2);
            $centerX = $centerX < 0 ? 0 : $centerX;
            $centerX = CEIL(($height - $text_height) / 2);
            $centerY = $centerX < 0 ? 0 : $centerX;
            // RANDOM OFFSET POSITION OF THE TEXT + COLOR
            // if (rand(0, 1)) {
            //     $centerX -= rand(0, 5);
            // } else {
            //     $centerX += rand(0, 5);
            // }
            $colornow = imagecolorallocate($captcha, rand(120, 255), rand(120, 255), rand(120, 255)); // Random bright color
            imagettftext($captcha, $fontsize, rand(-10, 10), $centerX, $centerY, $colornow, $font, $_SESSION['captcha']);
        } else {
            imagefilledrectangle($captcha, 0, 0, $width, $height, imagecolorallocate($captcha, 255, 255, 255));
        }

        // OUTPUT
        header('Content-type: image/png');
        imagejpeg($captcha);
        imagedestroy($captcha);
    }

    public static function verify($input)
    {
        // verify() : step 3, verifies the captcha
        // PARAM $input : user input

        // CAPTCHA NOT SET!
        if (!isset($_SESSION['captcha'])) {
            return false;
        }

        // CHECK
        if ($input == $_SESSION['captcha']) {
            unset($_SESSION['captcha']);
            return true;
        } else {
            return false;
        }
    }
}
