<?php

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 10:10
 */
class News_model extends CI_Model
{
    const NEWS_TABLE = APPLICATION_NEWS;
    const PAGE_LIMIT = 5;

    protected $id;
    protected $header;
    protected $short_description;
    protected $text;
    protected $img;
    protected $tags;
    protected $time_created;
    protected $time_updated;

    protected $views;

    protected $comments;
    protected $likes;

    function __construct($id = FALSE)
    {
        parent::__construct();
        $this->class_table = self::NEWS_TABLE;
        $this->load->database();
        $this->set_id($id);
    }

    /**
     * @return string
     */
    public function get_header()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function set_header($header)
    {
        $this->header = $header;
        return $this->_save('header', $header);
    }

    /**
     * @return string
     */
    public function get_short_description()
    {
        return $this->short_description;
    }

    /**
     * @param mixed $description
     */
    public function set_short_description($description)
    {
        $this->short_description = $description;
        return $this->_save('short_description', $description);
    }

    /**
     * @return string
     */
    public function get_full_text()
    {
        return $this->text;
    }


    
    public function set_id($id)
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function get_image()
    {
        return $this->img;
    }

    /**
     * @param mixed $image
     */
    public function set_image($image)
    {
        $this->img = $image;
        return $this->_save('image', $image);
    }

    /**
     * @return string
     */
    public function get_tags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function set_tags($tags)
    {
        $this->tags = $tags;
        return $this->_save('tags', $tags);
    }

    /**
     * @return mixed
     */
    public function get_time_created()
    {
        return $this->time_created;
    }

    /**
     * @param mixed $time_created
     */
    public function set_time_created($time_created)
    {
        $this->time_created = $time_created;
        return $this->_save('time_created', $time_created);
    }

    /**
     * @return int
     */
    public function get_time_updated()
    {
        return strtotime($this->time_updated);
    }

    /**
     * @param mixed $time_updated
     */
    public function set_time_updated($time_updated)
    {
        $this->time_updated = $time_updated;
        return $this->_save('time_updated', $time_updated);
    }

    /**
     * @return News_like_model
     */
    public function get_likes()
    {
        return $this->likes;
    }

    /**
     * @return News_comments_model[]
     */
    public function get_comments()
    {
        return $this->comments;
    }

    /**
     * @param int $page
     * @param bool|string $preparation
     * @return array
     */



    public  function get_all() {

        
        $this->db->select();

        $this->db->from('news');

        $this->db->order_by('time_created','desc');

        $query = $this->db->get();

         return $query->result_array();


        }

 



      public  function show($id) {

        $this->db->select();

        $this->db->from('news');

        $this->db->where(array('id'=>$id));

        $this->db->order_by('time_created','desc');

        $query = $this->db->get();

        return $query->first_row('array');
  }




 public  function show_last() 
 {

        $this->db->select('id,header,short_description');

        $this->db->from('news');

        $this->db->limit(5);

        $this->db->order_by('time_created', 'desc');

        $query = $this->db->get();

        return $query->result_array();
}





  public  function count_all()
  {

    return $this->db->count_all('news');

  }





    public function get_list($limit, $start) {

        $this->db->limit($limit, $start);

        $query = $this->db->get("news");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
              
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }


 



    public function get_results($search) 
       {
        
        $this->db->like('header',$search);

        $this->db->or_like('short_description',$search);

        $this->db->or_like('text',$search);

        $query = $this->db->get('news');

        return $query->result_array();

    }





   public function count_results($search) 
    {   
   
   $this->db->like('header',$search);

   $this->db->or_like('short_description',$search);

   $this->db->or_like('text',$search);

   $query = $this->db->get('news');

   return $query->num_rows(); 

   }




    public static function preparation($data, $preparation)
    {

        switch ($preparation) {
            case 'short_info':
                return self::_preparation_short_info($data);
            default:
                throw new Exception('undefined preparation type');
        }
    }

    /**
     * @param News_model[] $data
     * @return array
     */
    private static function _preparation_short_info($data)
    {
        $res = [];
        foreach ($data as $item) {
            $_info = new stdClass();
            $_info->id = (int)$item->get_id();
            $_info->header = $item->get_header();
            $_info->description = $item->get_short_description();
            $_info->img = $item->get_image();
            $_info->time = $item->get_time_updated();
            $res[] = $_info;
        }
        return $res;
    }
    
    
    public static function create($data){

        $CI =& get_instance();
	    $res = $CI->s->from(self::NEWS_TABLE)->insert($_insert_data)->execute();
	    if(!$res){
	        return FALSE;
        }
	    return new self($CI->s->insert_id);
    }
    

}
