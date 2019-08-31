<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->model('comments_model');
                $this->load->helper('url_helper');
                
              
              
        }




  function create(){
 
        $this->form_validation->set_rules('name', 'Name', 'trim|d');
        $this->form_validation->set_rules('email','Email','trim|d|valid_email');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|d');

        if ($this->form_validation->run() == FALSE) {

                $news_id=$this->input->post('news_id');
                $data['news'] = $this->news_model->show($news_id);
                $data['total'] = $this->comments_model->count_results($news_id);
                $data['comments'] = $this->comments_model->get_comment($news_id);
                $data['title'] = 'Comments to news';
                $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
        }
          

        else {

          $data = array(
              'name'=>$this->input->post('name'),
              'email'=>$this->input->post('email'),
              'comment'=>$this->input->post('comment'),
              'news_id'=>$this->input->post('news_id'), 
              'ip'=>$this->input->ip_address(),
              'created_at'=> date('Y-m-d H:i:s')); 
               $email = $this->input->post('email');
               $name = $this->input->post('name'); 
               $ip= $this->input->ip_address();  
               $comment=$this->input->post('comment');                
               $msg = "Comment: $comment с $ip";
               $config['mailtype'] = 'html';
               $this->email->initialize($config);
               $this->email->to('admin@devnews.com');
               $this->email->cc('webmaster@devnews.com');
               $this->email->from($email,$name);
               $this->email->subject('News comment');
               $this->email->message($msg);
               $this->email->send();
               $this->comments_model->add_comment($data);
               $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }
              
        
    

}


  function delete_comment($comment_id) {

  $this->comments_model->delete_comment($comment_id);
  $data['info'] = 'Comments was deleted';
   $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
  

  }




}
             