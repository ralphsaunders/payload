<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postutil {

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper( 'naming' );
    }

    /**
     * List Posts Recursively
     *
     * Returns a string containing an unordered
     * list of posts. $posts structure:
     *
     * Array
     * (
     *     [canvas-snake] => Array
     *         (
     *             [files] => Array
     *                 (
     *                     [0] => ./posted/canvas-snake/Canvas Is Badass.md
     *                     [1] => ./posted/canvas-snake/a-bend.png
     *                     [2] => ./posted/canvas-snake/direction-movement.js
     *                     ...
     *                 )
     *
     *         )
     *
     *     [misscrolling] => Array
     *         (
     *             [files] => Array
     *                 (
     *                     [0] => ./posted/misscrolling/Misscrolling herp derp.zip
     *                     ...
     *                 )
     *
     *         )
     *
     *     [phonographic-index] => Array
     *         (
     *             [2012] => Array
     *                 (
     *                     [May] => Array
     *                         (
     *                             [files] => Array
     *                                 (
     *                                     [0] => ./posted/phonographic-index/2012/May/Archive.zip
     *                                     [1] => ./posted/phonographic-index/2012/May/index.html
     *                                 )
     *
     *                             [css] => Array
     *                                 (
     *                                     [files] => Array
     *                                         (
     *                                             [0] => ./posted/phonographic-index/2012/May/css/reset.css
     *                                             [1] => ./posted/phonographic-index/2012/May/css/styles.css
     *                                         )
     *
     *                                 )
     *
     *                         )
     *
     *                 )
     *
     *         )
     *
     * )
     *
     * @param array
     * @param int
     */
    public function list_posts_recursively( $posts = array(), $nest_level = 0 )
    {
        $list = '';

        foreach( $posts as $key => $post )
        {
            if( isset( $post['files'] ) )
            {
                $list .= '<ul><li><h3><a ';
                $list .= 'href="' . $path = pathinfo( $post['files'][0], PATHINFO_DIRNAME ) . '" ';
                $list .= 'title="' . title_case( $key ) . '">' . title_case( $key );
                $list .= '</a></h3></li></ul>';

                continue;
            }
            else
            {
                $list .= '<ul><li><h2>' . title_case( $key ) . '</h2></li>';
                $list .= '<li>' . $this->list_posts_recursively( $post, $nest_level+=1 ) . '</li></ul>';
            }
        }

        return $list;
    }

}
?>
