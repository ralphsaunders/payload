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

            /**
             * Rename html files to index.html
             */
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

        // $posts = get_dir_file_info( $root, $top_level_only = true );

        $posts = $this->_fetch_posts( $root );
        log_message( 'debug', 'Fetched Posts:: ' . json_encode( $posts ) );

        $this->benchmark->mark( 'crawl_end' );

        return $posts;
    }

    /**
     * Fetch Posts
     *
     * Returns an n-dimensional array of the directory structure from $root.
     * Posts are nested according to their directory. The array containing the
     * directory's files is assigned the key 'files', otherwise the key is
     * always the directory's name. Example:
     *
     *      |~posted/
     *        |~category/
     *          |~a-post/
     *            |-index.html
     *            |-image.png
     *            `-notes.md
     *          |~another-post/
     *            |-index.html
     *            `-styles.css
     *        |~another-category/
     *          |~third-post/
     *
     *        ...
     *
     *      array(
     *          'posted' => array(
     *              'category' => array(
     *                  'a-post' => array(
     *                      'files' => array(
     *                          [0] => array(
     *                              'dirname' => '/posted/category/a-post',
     *                              'basename' => 'index.html',
     *                              'extension' => 'html',
     *                              'filename' => 'index'
     *                          ),
     *                          ...
     *                      )
     *                  ),
     *                  ...
     *              ),
     *              ...
     *          )
     *      );
     */
    private function _fetch_posts( $root )
    {
        $dirs = scandir($root);

        foreach($dirs as $dir)
        {
            if ($dir === '.' || $dir === '..')
            {
                continue;
            }
            elseif ( $dir[0] === '.' )
            {
                continue;
            }

            if( is_dir( $root . $dir ) )
            {
                $files=scandir($root.$dir);
            }
            else
            {
                $result['files'][] = $root . $dir;
                continue;
            }

            foreach ($files as $file)
            {
                if ($file === '.' || $file === '..')
                {
                    continue;
                }
                elseif( $file[0] === '.' )
                {
                    continue;
                }
                elseif( is_file( $root . $dir . '/' . $file ) )
                {
                    $result[$dir]['files'][] = $root.$dir.'/'.$file;
                }
                elseif( is_dir( $root . $dir . '/' . $file ) )
                {
                    $result[$dir][$file] = $this->_fetch_posts( $root . $dir . '/' . $file . '/' );
                }
            }
        }

        if( isset( $result ) )
        {
            return $result;
        }
        else
        {
            return array();
        }
    }

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */
