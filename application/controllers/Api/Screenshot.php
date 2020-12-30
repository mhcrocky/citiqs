<?php
// require(APPPATH.'/libraries/REST_Controller.php');

class Photo extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('label_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }


    public function allcategories_get()
    {
        $this->db->select('id, description');
        $this->db->from('tbl_category');
        $this->db->order_by('description');
        $query = $this->db->get();
        $result = $query->result_array();

        $this->response($result, 200);
    }


    public function upload_post()
    {
        // maak onderstaande directory writable.
        // chmod -R 777 /Applications/uploads

        $this->db->select('mode');
        $this->db->from('tbl_maintenance');
        $query = $this->db->get();
        if (!empty($query->row()))
        {
            $data['status'] = "0";
            $data['message'] = "We are currently doing some maintenance. Please, try again in 15 minutes";
            $this->response($data, 200);
            return;
        }

        switch (strtolower($_SERVER['HTTP_HOST']))
        {
            case 'tiqs.com':
                $uploaddir = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/';
                break;
            case 'loki-lost.com':
            case '10.0.0.48':
            case '192.168.1.67':
                $uploaddir = '/usr/share/nginx/html/lostandfound/uploads/LabelImages/';
                break;
            case '192.168.219.101':
                $uploaddir = FCPATH.'uploads/LabelImages/';
                break;
            default:
                $uploaddir = '/Users/peterroos/www/tiqs/application/uploads/LabelImages/';
                break;
        }

        ////Load and resize the image
        //$uploaded = imagecreatefromjpeg($_FILES['file']['tmp_name']);
        //$image = imagecreatetruecolor(IMAGE_WIDTH, IMAGE_HEIGHT);
        //imagecopyresampled($image, $uploaded, 0, 0, 0, 0, IMAGE_WIDTH, IMAGE_HEIGHT, imagesx($uploaded), imagesy($uploaded));
        //imagealphablending($image,true); //allows us to apply a 24-bit watermark over $image
        //
        ////Load the sold watermark
        //$sold_band = imagecreatefrompng('../images/sold_band.png');
        //imagealphablending($sold_band,true);
        //
        ////Apply watermark and save
        //$image = image_overlap($image, $sold_band);
        //imagecopy($image,$sold_band,IMAGE_WIDTH - SOLD_WIDTH,IMAGE_HEIGHT - SOLD_HEIGHT,0,0,SOLD_WIDTH,SOLD_HEIGHT);
        //$success = imagejpeg($image,'../images/sold/'.$id.'.jpg',85);
        //
        //imagedestroy($image);
        //imagedestroy($uploaded);
        //imagedestroy($sold_band);

        // chmod -R 777 /Applications/uploads
        // Onderstaande code is alleen een testje om te kijken of de upload dir writeable is
        /*
        $myFile = "testFile1.jpg";
        $fh = fopen($uploaddir .$myFile, 'w') or die("can't open file");
        $stringData = "Bobby Bopper\n";
        fwrite($fh, $stringData);
        $stringData = "Tracy Tanner\n";
        fwrite($fh, $stringData);
        fclose($fh);
        */


        // oude code van na move uploaden file
        // Add stamp, native PHP, zie:
        // http://php.net/manual/en/image.examples-watermark.php

        // Load the stamp and the photo to apply the watermark to
        /// $stamp = imagecreatefromgpng(FCPATH . '/tiqsimg/cover.png');
        /// $im = imagecreatefromjpeg($uploadfile);

        // Set the margins for the stamp and get the height/width of the stamp image
        ///$marge_right = 0;
        ///$marge_bottom = 0;
        ///$sx = imagesx($stamp);
        ///$sy = imagesy($stamp);

        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        ///imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

        // Output and free memory
        // Test in browser: uncomment:
        // header('Content-type: image/jpg');
        // imagejpeg($im); or:
        // imagepng($im);

        ///imagejpeg($im, $uploadfile . 'stamp.jpg', 100);
        ///imagedestroy($im);
        ///
        ///

        $valid_formats = array("jpg", "jpeg", "png");
        $filename = $_FILES['file']['name'];
        if (strlen($filename) > 0)
        {
            list($txt, $ext) = explode(".", strtolower($filename));
            if (!in_array($ext, $valid_formats))
            {
                $data['status'] = "0";
                $data['message'] = "Invalid photo format";
                $this->response($data, 200);
            }
        }
        else
        {
            $data['status'] = "0";
            $data['message'] = "Invalid photo filename";
            $this->response($data, 200);
            return;
        }

        // $hash = $_POST['hash'];
        $hash = $this->security->xss_clean($this->input->post('hash'));
        if (empty($hash))
        {
            $data['status'] = "0";
            $data['message'] = "You are not logged in. Please, login first";
            $this->response($data, 200);
            return;
        }

        // both fields always have a valid value
        // $descript = $_POST['descript'];
        $descript = $this->security->xss_clean($this->input->post('descript'));
        // $categoryid = $_POST['categoryid'];
        $categoryid = $this->security->xss_clean($this->input->post('categoryid'));

        // get userid by hash
        $userInfo = $this->user_model->getUserInfoByHash($hash);
        $labelInfo = array(
            'userId' => $userInfo->userId,
            'descript' => $descript,
            'categoryid' => $categoryid,
            'ipaddress' => $this->input->ip_address(),
            'createdDtm' => date('Y-m-d H:i:s' ),
            'lost' => 0);

        $labelInfo = $this->label_model->generateCodeAndInsertLabel($labelInfo);
        if (empty($labelInfo))
        {
            $data['status'] =  "0";
            $data['message'] = "Could not generate code for photo, try again";
            $this->response($data, 200);
            return;
        }

        $path = $uploaddir . $userInfo->userId . "-" . $labelInfo->code . '-';

        // $uploadfile = $uploaddir . basename($_FILES['file']['name']);
        // if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))

        if(move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']))
        {
            $fname = strval(time());
            $new_name = $path . $fname . '.' . $ext;
            $this->watermark_text($path . $_FILES['file']['name'], $new_name, $ext, $labelInfo->code);
            $new_name = $fname .'.jpg';

            $updatedlabelInfo = array('image' => $new_name,
                'userfoundId' => $userInfo->userId);
            if ($this->user_model->updateimg($updatedlabelInfo, $labelInfo->id, $userInfo->userId) > 0)
            {
                $data['status'] = "1";
                $data['code'] = $labelInfo->code;
                $data['message'] = "Photo successfully uploaded into your account. Your lost + found code is: " . $labelInfo->code . "\r\n\r\nWrite down the lost + found code on the tiqs plastic bag";
            }
            else
            {
                $data['status'] = "0";
                $data['message'] = "Photo with watermark not uploaded, try again";
            }
        }
        else
        {
            $data['status'] =  "0";
            $data['message'] = "Photo not uploaded, try again";
        }
        $this->response($data, 200);
    }


    private function watermark_text($oldimage_name, $new_image_name, $ext, $code){
        switch (strtolower($_SERVER['HTTP_HOST']))
        {
            case 'tiqs.com':
                $font_path = "/home/tiqs/domains/tiqs.com/public_html/lostandfound/assets/fonts/OpenSans-Bold.ttf"; // Font file
                break;
            case 'loki-lost.com':
            case '10.0.0.48':
            case '192.168.1.67':
                $font_path = "/usr/share/nginx/html/lostandfound/assets/fonts/OpenSans-Bold.ttf"; // Font file
                break;
            default:
                $font_path = '/Users/peterroos/www/tiqs/assets/fonts/OpenSans-Bold.ttf';
                break;
        }

        $font_size = 30; // in pixels
        $water_mark_text_2 = $code; // Watermark Text
        //global $font_path, $font_size, $water_mark_text_2;
        list($owidth,$oheight) = getimagesize($oldimage_name);
        $width =$owidth;
        $height = $oheight;
        $image = imagecreatetruecolor($width, $height);
        if ($ext == 'png')
        {
            $image_src = imagecreatefrompng($oldimage_name);
            imagejpeg($image_src, $oldimage_name, 100);
        }
        $image_src = imagecreatefromjpeg($oldimage_name);
        imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
        $blue = imagecolorallocate($image, 79, 166, 185);
        imagettftext($image, $font_size, 0, 0, $height - 30, $blue, $font_path, $water_mark_text_2);
        // imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
        // imagettftext is an in-built function.you can change variables for relocating position of watermark
        if ($ext == 'png')
            $new_image_name = str_replace("png", "jpg", $new_image_name);

        $x=imagejpeg($image, $new_image_name, 100);
        imagedestroy($image);
        unlink($oldimage_name);
        return true;
    }

}

?>
