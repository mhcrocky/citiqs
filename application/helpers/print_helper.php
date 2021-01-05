<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Print_helper
    {

        public static function printImageLogo(object &$image, string $logoFile): void
        {
            $imagelogo = new Imagick($logoFile);
            $geometry = $imagelogo->getImageGeometry();
            $width = intval($geometry['width']);
            $height = intval($geometry['height']);
            $crop_width = 550;
            $crop_height = 150;
            $crop_x = intval(($width - $crop_width) / 2);
            $crop_y = intval(($height - $crop_height) / 2);
            $sizeheight = 300;
            $sizewidth = 576;

            $imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
            $imagelogo->setImageFormat('png');
            $imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
            $imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);

            $image->addImage($imagelogo);
            $imagelogo->destroy();
        }
    }
