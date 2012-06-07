<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/setup
	 *	- or -
	 * 		http://example.com/index.php/setup/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/setup/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $data['title'] = 'Payload &mdash; Setup';
        $data['view'] = 'setup/setup_message';
        $this->load->view( 'includes/template', $data );
    }

    /**
     * Open The Pod Bay Doors
     *
     * Manages setup of payload including database creation, and instantiation.
     *
     * @return void
     */
    public function open_the_pod_bay_doors()
    {
        $this->load->model('database_model');
        $setup = $this->database_model->create();

        if( $setup['errors'] )
        {
            $data['title'] = 'Payload &mdash; Setup Errors';
            $data['errors'] = $setup['errors'];
            $data['view'] = 'setup/setup_errors';
            $this->load->view( 'includes/template', $data );
        }
        else
        {
            $data['title'] = 'Payload &mdash; Setup Success';
            $data['view'] = 'setup/setup_complete';
            $this->load->view( 'includes/template', $data );
        }
    }
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */
