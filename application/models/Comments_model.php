<?php


class Comments_model extends CI_Model {


public function __construct()
{

   $this->load->database();

}



 public  function show_last() {

        $this->db->select('name, email, comment');

        $this->db->from('comments');

        $this->db->limit(5);

        $this->db->order_by('created_at', 'desc');

        $query = $this->db->get();

        return $query->result_array();
}





    function get_comment($comment_id)
    {
        $this->db->select('name, email, comment, created_at');
        $this->db->from('comments');
        $this->db->where('news_id',$comment_id);
        $this->db->order_by('created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }





    public function add_comment($data)
    {
        $this->db->insert('comments',$data);
        
        return $this->db->insert_id();
    }
    



  public  function count_id($id)
   {

    $this->db->where('news_id', $id)->get('comments');

    return $this->db->count_all_results();

   }






public function count_results($news_id) 
{   

   $this->db->where("news_id",$news_id);
  
   $query = $this->db->get('comments');

   return $query->num_rows(); 

}



 public function delete_comment($id){

    $this->db->where('id', $id);

    $this->db->delete('comments');

   }









}

