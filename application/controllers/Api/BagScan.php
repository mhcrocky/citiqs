<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH . 'libraries/REST_Controller_Definitions.php';
//require APPPATH . 'libraries/REST_Controller.php';
//require APPPATH . 'libraries/Format.php';

class BagScan extends REST_Controller
{
    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
        $this->load->library('language', array('controller' => $this->router->class));
    }


    /*
     * check tag and sticker and return corresponding stickers
     *
     * http://10.0.0.48/Api/BagScan/checktagandsticker
     *
     * sticker: SELECT * FROM `tbl_uniquecodes` WHERE id=921631
     * SELECT * FROM `tbl_uniquecodes` WHERE bagid  is not null
     * update `tbl_uniquecodes` set bagid  = null where bagid is not null
     * tag LFnXPdDa
     * sticker S-fHCkB73X
     *
     * SELECT code,qrcode FROM `tbl_uniquecodes` where id>=700002 and id<=800601 order by id

        1-100000 eerste batch labels            1-100000 	GanAVeS8 - wMsFHc8t         labels, naar Chinees
        100001-600000 eerste batch stickers     100001-600000	q4HRbJgW - BVemGd3Y
        600001-700001 tweede batch labels       600001-700000	A4d9ESX7 - HxLnRyXm     labels naar andere Chinees
        700002-800601 tweede batch stickers     700001-800600	vhgs5AyD - T4jraSd3
        800602-950601 derde batch stickers,     800601-950600	S-jTmbyNGg - S-6BQqWdHR => dit zijn er 3 per vel
             nieuw model grotere qr code

     */

    public function getnextbagid_post()
    {
        $this->db->trans_start();
        $this->db->query('update tbl_bagid set bagid = bagid + 1');
        $this->db->select('bagid');
        $this->db->from('tbl_bagid');
        $query = $this->db->get();
        $bagid = $query->row()->bagid;
        $this->db->trans_complete();

        $message['bagid'] =  "$bagid";
        $this->response($message, 200);
    }


    public function checktagandsticker_post()
    {
        $message = array();

        $tag = $this->security->xss_clean($this->input->post('tag'));
        $sticker = $this->security->xss_clean($this->input->post('sticker'));
        $bagId = intval($this->security->xss_clean($this->input->post('bag')));

        $this->db->select('id, bagid');
        $this->db->from('tbl_uniquecodes');
        $this->db->where('code', $tag);
        $where = "((id >= 1 and id <= 100000) or (id >= 600001 and id <= 700000))";
        $this->db->where($where);
        $query = $this->db->get();
        $tagresult = $query->row();

        if(empty($tagresult))
        {
            $message['tag'] = $tag;
            $message['status'] = "0";
            $message['message'] = "Tag cannot be found. Keep tag save and report to Peter or scan tag first and not a sticker first.";
            $this->response($message, 200);
            return;
        }

        if (!is_null($tagresult->bagid))
        {
            $message['tag'] = $tag;
            $message['status'] =  "0";
            $message['message'] = "Tag has already been assigned to bag " . $tagresult->bagid;
            $this->response($message, 200);
            return;
        }

        $this->db->select('id, bagid');
        $this->db->from('tbl_uniquecodes');
        $this->db->where('code', $sticker);
        $where = "((id >= 100001 and id <= 600000) or (id >= 700001 and id <= 800600) or (id >= 800601 and id <= 950600))";
        $this->db->where($where);
        $query = $this->db->get();
        $stickerresult = $query->row();

        if(empty($stickerresult))
        {
            $message['stickers'][] = $sticker;
            $message['status'] =  "0";
            $message['message'] = "Sticker cannot be found. Keep sticker save and report to Peter or scan sticker after tag.";
            $this->response($message, 200);
            return;
        }

        if (!is_null($stickerresult->bagid))
            {
            $message['stickers'][] = $sticker;
            $message['status'] =  "0";
            $message['message'] = "Sticker has already been assigned to bag." . $stickerresult->bagid;
            $this->response($message, 200);
            return;
            }

        $stickerId = $stickerresult->id;

        if ($stickerId == 599999 || $stickerId == 600000 || $stickerId == 700001)
        {
            $message['status'] =  "0";
            $message['message'] = "You have found the golden sticker! Keep it a safe place. It will be worth millions soon. Contact Peter.";
            $this->response($message, 200);
            return;
        }

        if ($stickerId >= 100001 and $stickerId <= 600000)
        {
            $sequenceNumber = ($stickerId - 100001) % 3;
            $numberofStickers = 3;
        }

        // sticker 700001 is the third sticker on page 1083, so skip this one for the algoritm to work
        if ($stickerId >= 700002 and $stickerId <= 800600)
        {
            $sequenceNumber = ($stickerId - 700002) % 3;
            $numberofStickers = 3;
        }

        if ($stickerId >= 800601 and $stickerId <= 950600)
        {
            $sequenceNumber = ($stickerId - 800601) % 3;
            $numberofStickers = 3;
        }

        $message = [
            'tag' => $tag,
            'stickers' => array(),
            'status' => "1",
            'message' => "OK"
        ];

        $stickerId -= $sequenceNumber;
        $query = $this->db->get_where('tbl_uniquecodes', array('id >=' => $stickerId, 'id <' => $stickerId + $numberofStickers));
        foreach ($query->result() as $row)
        {
            $message['stickers'][] = $row->code;

            $bagIds[] = array(
                'id' => $row->id,
                'bagid' => $bagId
            );
        }

        // add bagId to tag too
        $bagIds[] = array(
            'id' => $tagresult->id,
            'bagid' => $bagId
        );


        $rowsAffected = $this->db->update_batch('tbl_uniquecodes', $bagIds, 'id');
        if ($rowsAffected != $numberofStickers + 1)
        {
            $message['status'] = "0";
            $message['message'] = "Cannot assign bag to tag and stickers. Keep tag and stickers save and report to Peter.";
        }


        $this->set_response($message, 200); // CREATED (201) being the HTTP response code
    }

}
