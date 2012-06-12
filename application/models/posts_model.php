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

    /**
     * Crawl
     *
     * Crawls /posted/ and returns array
     */
    public function crawl( $from = 0 )
    {
        $root = './posted/';
        $this->load->helper( 'naming' );
        $this->load->helper( 'file' );
        $posts = get_dir_file_info( $root, $top_level_only = true );
        $posts = array_slice( $posts, $from, 25 );

        log_message( 'debug', 'Posts:: ' . json_encode( $posts ) );

        /**
         * any Old Name.html => index.html
         */
        foreach( $posts as $post )
        {
            $post_files = get_filenames( $root . $post['name'] );

            log_message( 'debug', 'Post Files:: ' . json_encode( $post_files ) );

            foreach( $post_files as $filename )
            {
                $file_info = PATHINFO( $root . $post['name'] . $filename );

                if($file_info['extension'] == 'html' && $file_info['filename'] == 'index' )
                {
                    break;
                }
                elseif( $file_info['extension'] == 'html' )
                {
                    rename( $root . $post['name'] . '/' . $filename, $root . $post['name'] . '/' . 'index.html' );
                    break;
                }
            }

            rename( $root . $post['name'], $root . format_url( $post['name'] ) );
            $post_dirs[] = format_url( $post['name'] );
        }

        $posts = get_dir_file_info( $root, $top_level_only = true );
        $posts = array_slice( $posts, $from, 25 );

        return $posts;
    }

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */
