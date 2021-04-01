<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Uploadfile_helper
    {

        public static function uploadFiles(string $folder, array $constraints = [], bool $resize = true, array $sizeConstraints = []): bool
        {
            $folder = rtrim($folder, DIRECTORY_SEPARATOR);
            $CI =& get_instance();
            $constraints['upload_path'] = $folder . DIRECTORY_SEPARATOR;
            $constraints['allowed_types'] = (isset($constraints['allowed_types'])) ? $constraints['allowed_types'] : 'jpeg|jpg|png';
            $CI->load->library('upload');

            $CI->upload->initialize($constraints, FALSE);
            foreach($_FILES as $key => $file) {
                if ($_FILES[$key]['name']) {
                    if (!$CI->upload->do_upload($key)) return false;
                    if ($resize) self::resizeImage($sizeConstraints);
                }
            }
            return true;
        }

        public static function uploadFilesNew(string $folder, array $constraints = [], bool $resize = true, array $sizeConstraints = []): bool
        {
            $CI =& get_instance();
            $constraints['upload_path'] = $folder;
            $constraints['allowed_types'] = (isset($constraints['allowed_types'])) ? $constraints['allowed_types'] : 'jpeg|jpg|png';
            $CI->load->library('upload');

            $CI->upload->initialize($constraints, FALSE);
            foreach($_FILES as $key => $file) {
                if ($_FILES[$key]['name']) {
                    if (!$CI->upload->do_upload($key)) return false;
                    if ($resize) self::resizeImage($sizeConstraints);
                }
            }
            return true;
        }

        public static function insertFiles(array &$postColumns, string $folder): bool
        {
            if (count($_FILES)) {
                if (!self::uploadFiles($folder)) { 
                    return false;
                }
                foreach($_FILES as $key => $file) {
                    if ($file['name']) {
                        $postColumns[$key] = $file['name'];
                    }
                }
            }
            return true;
        }

        public static function resizeImage(array $sizeConstraints = []): void
        {
            $CI =& get_instance();
            $imgInfo = $CI->upload->data();
            $CI->load->library('image_lib');
            $config = [
                'image_library' => 'gd2',
                'maintain_ratio' => TRUE,
                'source_image' => $imgInfo['full_path'],
                'width' => $imgInfo['image_width'],
                'height' => $imgInfo['image_height'],
            ];
            if (empty($sizeConstraints)) {
                self::resizeWidthAndHeight($config['width'], $config['height']);
            } else {
                self::resizeWidthAndHeight($config['width'], $config['height'], $sizeConstraints['maxWidth'], $sizeConstraints['maxHeight']);
            }

            $CI->load->library('image_lib', $config);
            $CI->image_lib->clear();
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
        }

        public static function resizeWidthAndHeight(int &$width, int &$height, int $maxWidth = 551,  int $maxHeight = 551): void
        {
            while ($width > $maxWidth || $height > $maxHeight) {
                $width = $width * 0.95;
                $height = $height * 0.95;
            }
            $width = round($width);
            $height = round($height);
            return;
        }

        public static function getFileExtension(string $file): string
        {
            $pieces = explode('.', $file);
            return strtolower($pieces[count($pieces) - 1]);
        }

        public static function changeImageName(string $old, string $new): bool
        {
            chmod($old, 0777);
            $result = rename($old, $new);
            if ($result) {
                chmod($new, 0644);
            }            
            return $result;
        }

        public static function uploadLabel(array $constraints = []): bool
        {            
            $CI =& get_instance();
            $CI->load->config('custom');

            $constraints['upload_path'] = $CI->config->item('labelFolder');
            $constraints['allowed_types'] = (isset($constraints['allowed_types'])) ? $constraints['allowed_types'] : 'jpeg|jpg|png';
            
            $CI->load->library('upload');
            $CI->upload->initialize($constraints, FALSE);
            
            foreach($_FILES as $key => $file) {
                if ($_FILES[$key]['name']) {
                    if (!$CI->upload->do_upload($key)) return false;
                    self::copyUploadedLabel($_FILES[$key]['name']);
                    self::resizeImage();
                    self::addWaterMarkToLabelImages($_FILES[$key]['name']);
                }
            }

            return true;
        }

        public static function copyUploadedLabel(string $name): bool
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $source = $CI->config->item('labelFolder') . $name;
            $destination = $CI->config->item('labelFolderBig'). $name;            

            if (!copy($source, $destination)) return false;
            
            chmod($source, 0644);
            chmod($destination, 0644);

            return true;
        }

        public static function renameLabel(string $imageFullName, string $imageDatabaseName, string $userId, string $code): bool
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $folders = [$CI->config->item('labelFolder'), $CI->config->item('labelFolderBig')];
            foreach($folders as $folder) {
                $oldImage = $folder . $imageFullName;
                if (file_exists($oldImage)) {
                    
                    $newImage = $folder . $userId . '-' . $code . '-' . $imageDatabaseName;
                    if (!self::changeImageName($oldImage, $newImage)) return false;
                }
            }
            return true;
        }

        public static function getSensitiveImage(int $categoryId): string
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            switch ($categoryId) {
                case $CI->config->item('creditCard'):
                    $image = base_url() . 'assets/home/images/creditcardsbankcards.png';
                    break;
                case $CI->config->item('debitCard'):
                    $image = base_url() . 'assets/home/images/creditcardsbankcards.png';
                    break;
                case $CI->config->item('driverLicense'):
                    $image = base_url() . 'assets/home/images/Driverslicense.png';
                    break;
                case $CI->config->item('identityCard'):
                    $image = base_url() . 'assets/home/images/id.png';                    
                    break;
                case $CI->config->item('passport'):
                    $image = base_url() . 'assets/home/images/pasport-id.png';            
                    break;
                case $CI->config->item('sensitiveData'):
                    $image = base_url() . 'assets/home/images/somethingreallypersonal.png';
                    break;
                default:
                    $image = '';                    
                    break;                
            }

            return $image;
        }

        public static function addWaterMarkToLabelImages(string $imageName): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $folders = [$CI->config->item('labelFolder'), $CI->config->item('labelFolderBig')];
            $font_path = FCPATH . 'assets/fonts/OpenSans-Bold.ttf';

            foreach($folders as $folder) {
                $imageSrc = $folder . $imageName;
                chmod($imageSrc, 0777);

                $imageExtension = self::getFileExtension($imageSrc);
                $image = ($imageExtension === 'png') ? imagecreatefrompng($imageSrc) : imagecreatefromjpeg($imageSrc);
                
                $waterMarkText = explode('-', $imageName);
                $waterMarkText = $waterMarkText[1] . '-' . $waterMarkText[2];
                $textcolor = imagecolorallocate($image, 79, 166, 185);
                list($width,$height) = getimagesize($imageSrc);
                $fontSize = round($height * 0.1);

                imagettftext($image, $fontSize, 0, 10, ($height - 30), $textcolor, $font_path, $waterMarkText);
                imagejpeg($image, $imageSrc, 100);
                imagedestroy($image);
                chmod($imageSrc, 0644);
            }
        }

        public static function unlinkFile(string $file): bool
        {
            if (is_file($file)) {
                return unlink($file);
            }
            return true;
        }

        public static function changeFilesNameValue(string $key, int $userId): void
        {
            $_FILES[$key]['name'] = $userId . '_' . time() . '_' . rand(1000, 99999) . '.' . self::getFileExtension($_FILES[$key]['name']);
        }
    }