<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/posts
	 *	- or -
	 * 		http://example.com/index.php/posts/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/posts/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
    {
        $this->load->model( 'posts_model' );

        $posts = $this->posts_model->crawl();

        if( $posts = $this->posts_model->get() )
        {
            $data['posts'] = $posts;
        }

        $data['title'] = 'Payload';
        $data['view'] = 'blog/home';
        $this->load->view( 'includes/template', $data );
	}
}

/* End of file posts.php */
/* Location: ./application/controllers/posts.php */
