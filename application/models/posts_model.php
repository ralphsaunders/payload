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
     * Crawls /posted/ renaming directories and html files for pretty urls.
     *
     * @param  int
     * @return array
     */
    public function crawl( $from = 0 )
    {
        $this->benchmark->mark( 'crawl_start' );

        $root = './posted/';
        $absolute_root = realpath( $root );

        log_message( 'debug', 'Absolute Root: ' . $absolute_root );

        $this->load->helper( 'naming' );
        $this->load->helper( 'file' );
        $posts = get_dir_file_info( $root, $top_level_only = true );
        $posts = array_slice( $posts, $from, 25 );

        log_message( 'debug', 'Posts:: ' . json_encode( $posts ) );

        $this->benchmark->mark( 'post_loop_start' );

        /**
         * Loop through directories in the $root directory formatting directory
         * names for pretty URLs as well as renaming .html files to
         * 'index.html'.
         */
        foreach( $posts as $post )
        {
            $post_files = get_filenames( $root . $post['name'], $prepend_paths = true );

            log_message( 'debug', 'Post Files:: ' . json_encode( $post_files ) );

            foreach( $post_files as $filename )
            {
                $filename = str_replace( $absolute_root, '', $filename );

                log_message( 'debug', 'Filename: ' . $filename );

                $file_info = PATHINFO( $root . $filename );

                log_message( 'debug', 'Fileinfo: ' . json_encode( $file_info ) );

                if($file_info['extension'] == 'html' && $file_info['filename'] == 'index' )
                {
                    break;
                }
                elseif( $file_info['extension'] == 'html' )
                {
                    rename( $root . $filename, $file_info['dirname'] . '/' . 'index.html' );
                    break;
                }
            }

            rename( $root . $post['name'], $root . format_url( $post['name'] ) );
            $post_dirs[] = format_url( $post['name'] );
        }

        $this->benchmark->mark( 'post_loop_end' );

        $posts = get_dir_file_info( $root, $top_level_only = true );
        $posts = array_slice( $posts, $from, 25 );

        $this->benchmark->mark( 'crawl_end' );

        return $posts;
    }

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */
