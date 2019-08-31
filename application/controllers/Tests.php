<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 21:36
 */
class Tests extends CI_Controller
{
    protected $response_data;

    public function __construct()
    {
        parent::__construct();

       
        $this->load->model('news_model');
        $this->load->model('comments_model');
        $this->load->model('likes_model');
        $this->load->helper('url_helper');
        $this->response_data = new stdClass();
        $this->response_data->status = 'success';
        $this->response_data->error_message = '';
        $this->response_data->data = new stdClass();

      
    }
  
    public function index()
    {
         $data['news'] = $this->news_model->get_all();
         $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }



    public function get_last_news()
    {
         $data['news'] = $this->news_model->show_last();
         $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
       
    }

    

        public function show($id)
        {
                
                $data['news'] = $this->news_model->show($id);
                $data['total_comments'] = $this->comments_model->count_results($id);
                $data['total_likes'] = $this->likes_model->count_results($id);
                $data['comments'] = $this->comments_model->get_comment($id);
                $data['title'] = 'News';
                $data['news'] = $this->news_model->show($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
        }



        public function search(){         
                      
                $query = $this->input->get('query');
                if (empty($query) or strlen($query)< 3) {
                $data['title']="News: search results";
                $data['search'] = $query;
                $data['count'] = 0;
                $data['error_message'] = "Wrong entry";
                $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
                }
                else
                {
                $data['search'] = trim($query);
                $data['count'] = $this->news_model->count_results($query);
                $data['title']="News: search results";
                $data['error_message'] = "";
                $data['search_data'] = $this->news_model->get_results($query);
                  $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
                }

          }
     

         


}
