<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/23/15
 * Time: 5:39 PM
 */
include_once('base.php');
Class User_Photos extends Base
{
    /**
     * @var User_Model
     */
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_Model', 'userModel');
    }

    public function index()
    {
        $uId = $this->input->get('userId');
        $userId = ($uId) ? $uId : get_current_user_id();
        $photos = $this->userModel->getAllPhotos($userId);
        $this->renderSocialView('user/photo/view', array(
            'photos' => $photos,
            'user'   => $userId
        ), true);
    }

    public function addImages()
    {
        $config['upload_path'] = UPLOAD_PHOTOS_DIR;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('myImages')) {
            $error = $this->upload->display_errors();
            echo $error;
        }
        else {
            $data = $this->upload->data();
            $path = UPLOAD_PHOTOS_DIR;
            $fileName = $data['file_name'];
            $userId = get_current_user_id();
            $description = $this->input->post('txtDescription');

            $dataPhotos = array(
                'user_id' => $userId,
                'name' => $fileName,
                'path' => $path,
                'description' => $description
            );

            $this->userModel->addUserPhotos($dataPhotos);
            redirect(get_option('siteurl') . '/social-user-photos/', 'refresh');
        }
    }
}
?>
