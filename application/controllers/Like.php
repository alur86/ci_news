<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Like extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->model('comments_model');
                $this->load->model('likes_model');
                $this->load->helper('url_helper');

              
        }


  function create(){
 
        $this->form_validation->set_rules('like', 'Like', 'integer|d');

        if ($this->form_validation->run() == FALSE) {

                $news_id=$this->input->post('news_id');
                $data['news'] = $this->news_model->show($news_id);
                $data['total comments'] = $this->comments_model->count_results($news_id);
                $data['total likes'] = $this->likes_model->count_results($news_id);
                $data['comments'] = $this->comments_model->get_comment($news_id);
                $data['title'] = 'Like to comment of news';
                $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }
          

        else {

          $data = array(
              'like'=>$this->input->post('like'),
              'comment_id'=>$this->input->post('comment_id'), 
              'created_at'=> date('Y-m-d H:i:s')); 
               $this->like_model->add_like($data);
               $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }
              
        



}


  function delete_like($like_id) {

  $this->likes_model->delete_like($like_id);
  $data['info'] = 'Like was deleted';
   $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));

  }




}