<?php
require APPPATH . '/libraries/BaseControllerWeb.php';

class Alfred_migrate extends BaseControllerWeb
{

    public function index()
    {
        

        $post = $this->input->post(null, true);

        if (empty($post['password'])) {
            $this->global['pageTitle'] = 'TIQS : MIGRATIONS';
            $this->loadViews('migration', $this->global, null, 'nofooter', 'noheader');
        }
    }

}
