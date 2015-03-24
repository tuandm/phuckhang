<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/23/15
 * Time: 5:39 PM
 */
Class User_Photos extends CI_Controller
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
        $photos = $this->userModel->getAllPhotos();
        $this->load->view('layout/layout', array(
            'content' => $this->render('user/photo/view', array(
                'photos' => $photos
            )),
        ));
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