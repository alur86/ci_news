<?php


class Likes_model extends CI_Model {


public function __construct()
{

   $this->load->database();

}



    function get_like($comment_id)
    {
        $this->db->select('like');
        $this->db->from('likes');
        $this->db->where('comment_id',$comment_id);
        $query = $this->db->get();
        return $query->result_array();
    }





    public function add_like($data)
    {
        $this->db->insert('likes',$data);

        return $this->db->insert_id();
    }
    

  public function delete_like($id){

    $this->db->where('id', $id);

    $this->db->delete('likes');

   }




   public function count_results($comment_id) {   

   $this->db->where("comment_id",$comment_id);
  
   $query = $this->db->get('likes');

   return $query->num_rows(); 

   }











}

