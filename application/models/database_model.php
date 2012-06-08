<?php

/**
 * Database Model
 *
 * Manages database stucture and creation.
 */
class Database_model extends CI_Model {

    /**
     * Create Database
     *
     * Creates database tables and fields.
     *
     * @access public
     * @return bool
     */
    function create()
    {
        /**
         * This is a dirty hack.
         *
         * SQLite doesn't support database listing as each
         * database is a different file.
         *
         * The code below gets file information from the root
         * directory and looks at the filesize of "database.db".
         *
         * If "database.db" has a filesize of 0 (i.e. it
         * has not been written to) private functions setup
         * the database.
         */
        $this->load->helper( 'file' );
        $this->load->helper( 'error' );

        $info = get_dir_file_info( './', $top_level_only = true );

        if( $info['db.sqlite3']['size'] > 0 )
        {
           // Database is already setup
           return error('Database was already setup');
        }
        else
        {
            $this->_create_posts();
            $this->_create_sitemap();

            return true;
        }
    }

    /**
     * Create Posts
     *
     * Creates "posts" table and fields within it.
     *
     * @access private
     * @return bool
     */
    function _create_posts()
    {
        $this->load->dbforge();

        $post_fields = array(
            'title' => array(
                'type' => 'text'
            ),

            'raw' => array(
                'type' => 'text'
            ),

            'parsed' => array(
                'type' => 'text'
            ),

            'raw_format' => array(
                'type' => 'text'
            ),

            'url' => array(
                'type' => 'text'
            ),

            /**
             * Published & Edited fields
             *
             * SQLite3 doesn't have a separate storage class for date & time
             * fields but will store them as text, real, and integer types. The
             * `text` type takes ISO8601 strings.
             *
             * http://www.sqlite.org/datatype3.html
             */
            'published' => array(
                'type' => 'text'
            )
        );

        $this->dbforge->add_field( 'id INTEGER PRIMARY KEY' );
        $this->dbforge->add_field( $post_fields );

        if( $this->dbforge->create_table( 'posts' ) )
        {
            return true;
        }
        else
        {
            die( 'could not create table "posts"' );
        }
    }

    /**
     * Create Sitemap
     *
     * Creates "Sitemap" table and fields within it.
     *
     * @access private
     * @return bool
     */
    function _create_sitemap()
    {
        $this->load->dbforge();

        $sitemap_fields = array(
            'posted' => array(
                'type' => 'text'
            )
        );

        $this->dbforge->add_field( 'id INTEGER PRIMARY KEY' );
        $this->dbforge->add_field( $sitemap_fields );

        if( $this->dbforge->create_table( 'sitemap' ) )
        {
            return true;
        }
        else
        {
            die( 'could not create table "sitemap"' );
        }
    }

}

/* End of file database_model.php */
/* Location: ./application/models/database_model.php */
