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
     * Crawls /posted/ looking for changes in the filesystem. The filesystem is
     * stored as a serialized array in the 'sitemap' table of the database.
     */
    public function crawl()
    {
        $this->load->helper( 'file' );
        $posts = get_dir_file_info( './posted/', $top_level_only = true );

        log_message( 'debug', 'POSTS: ' . json_encode( $posts ) );

        $this->db->select( '* FROM sitemap' );
        $query = $this->db->get();

        if( $query->num_rows() > 0 )
        {
            $sitemap = $query->row();
            $sitemap = unserialize( $sitemap->posted );

            log_message( 'debug', 'SITEMAP from DB: ' . json_encode( $sitemap ) );

            foreach( $posts as $post )
            {
                $index[] = $this->_format_url( $post['name'] );
            }

            /**
             * Compares the top level of each array
             */
            $diff = array_diff( $index, $sitemap );

            log_message( 'debug', 'DIFF:: ' . json_encode( $diff ) );

            if( ! empty( $diff ) )
            {
                // Index new posts
                $this->_index( $diff );

                // Update sitemap
                $this->_update_sitemap( $diff, $sitemap );
            }
        }
        else
        {
            $this->_index( $posts );
            $this->_update_sitemap( $posts, null, false );
        }
    }

    /**
     * Index
     *
     * Adds given posts to the database
     */
    private function _index( $dirs )
    {
        $this->load->helper( 'url' );

        if( is_array( $dirs ) )
        {
            foreach( $dirs as $path )
            {
                $files = get_filenames( './posted/' . $path['name'] );

                log_message( 'debug', 'FILES: ' . json_encode( $files ) );

                foreach( $files as $file )
                {
                    $file_info = pathinfo( $file );

                    if( $file_info['extension'] == 'html' )
                    {
                        $dir_path = './posted/' . $path['name'] . '/';
                        rename( $dir_path . $file, $dir_path . 'index.html' );

                        $file = 'index.html';

                        $index[] = array(
                            'title' => $file_info['filename'],
                            'raw' => file_get_contents( $dir_path . $file ),
                            'parsed' => file_get_contents( $dir_path . $file ),
                            'raw_format' => $file_info['extension'],
                            'url' => $this->_format_url( $path['name'] ),
                            'published' => date('c')
                        );
                    }
                }
            }
        }
        else
        {
            $files = get_filenames( './posted/' . $dirs['name'] );

            log_message( 'debug', json_encode( $files ) );

            foreach( $files as $file )
            {
                $file_info = pathinfo( $file );

                if( $file_info['extension'] == 'html' )
                {
                    $dir_path = './posted/' . $path['name'] . '/';
                    rename( $dir_path . $file, $dir_path . 'index.html' );

                    $file = 'index.html';

                    $index[] = array(
                        'title' => $file_info['filename'],
                        'raw' => file_get_contents( 'posted/' . $dirs['name'] . '/' . $file ),
                        'parsed' => file_get_contents( 'posted/' . $dirs['name'] . '/' . $file ),
                        'raw_format' => $file_info['extension'],
                        'url' => $this->_format_url( $dirs['name'] ),
                        'published' => date('c')
                    );
                }
            }

        }

        if( isset( $index ) )
        {
            foreach( $index as $item )
            {
                $this->db->insert( 'posts', $item );
            }
        }
    }

    /**
     * Update Sitemap
     *
     * Rewrites directory names that appear in diff, prepends to sitemap, then
     * updates sitemap database.
     *
     * @param  array
     * @param  array
     */
    private function _update_sitemap( $diff, $sitemap = null, $update = true )
    {
        foreach( $diff as $path )
        {
            $paths[] = $this->_format_url( $path['name'] );
            rename( './posted/' . $path['name'], './posted/' . $this->_format_url( $path['name'] ) );
        }

        if( isset( $sitemap ) )
        {
            $new_sitemap = array_push( $sitemap, $paths );
        }
        else
        {
            $new_sitemap = $paths;
        }

        log_message( 'debug', 'NEW SITEMAP: ' . json_encode( $new_sitemap ) );

        $posted = array(
            'posted' => serialize( $new_sitemap )
        );

        if( $update )
        {
            $this->db->where( 'id', 1 );
            $this->db->update( 'sitemap', $posted );
        }
        else
        {
            $this->db->insert( 'sitemap', $posted );
        }
    }

    /**
     * Format Url
     *
     * Turns /Path To FilEs/ into /path-to-files/
     *
     * @param  string
     * @return string
     */
    private function _format_url( $path )
    {
        return strtolower( str_replace( ' ', '-', $path ) );
    }
}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */
