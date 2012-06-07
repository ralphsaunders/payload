<?php

/**
 * Posts Model
 *
 * Handles CRUD related functionality for uploaded posts
 */
class Posts_model extends CI_Model {

    public function get()
    {
        $this->db->select('* FROM posts');
        $query = $this->db->get();

        if( $query->num_rows() > 0 )
        {
            foreach( $query->result() as $post )
            {
                $posts[] = $post;
            }

            return $posts;
        }
        else
        {
            return false;
        }
    }
}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */
