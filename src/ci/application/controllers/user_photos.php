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
        $this->load->model('User_Model', 'userModel');
    }

    public function index()
    {
        $userId = $this->input->get('userId');

        if($userId == false) {
            $userId = wp_get_current_user()->ID;
            $photos = $this->userModel->getAllPhotos($userId);
        } else {
            $photos = $this->userModel->getAllPhotos($userId);
        }

        $this->renderSocialView('user/photo/view', array(
            'photos' => $photos
        ), true);
    }

    public function addImages()
    {
        $config['upload_path'] = 'upload';
        $config['allowed_types'] = 'jpg|png|gif';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('myImages')) {
            $error = $this->upload->display_errors();
            echo $error;
        }
        else {
            $data = $this->upload->data();
            $path = "upload/";
            $fileName = $data['file_name'];
            $user = wp_get_current_user();
            $description = $this->input->post('txtDescription');

            $dataPhotos = array(
                'user_id' => $user->ID,
                'name' => $fileName,
                'path' => $path,
                'description' => $description
            );

            $this->userModel->addUserPhotos($dataPhotos);
            $this->index();
        }
    }
}

?>