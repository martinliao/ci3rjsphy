<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

class BackendController extends MI_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout, ....
     */
    protected $data = array();

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(true);
        $CI =& get_instance();
        $this->load->library('smarty_acl');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
debugBreak();
        $this->logged_in();
        $this->smarty_acl->authorized();
        //Example data: 
        $this->data['sitename'] = 'CodeIgniter-HMVC';
        $this->data['site_title'] = ucfirst('Admin Dashboard');
    }

    protected function logged_in()
    {
        if (!$this->smarty_acl->logged_in()) {
            return redirect('admin/login');
        }
    }

    /**
     * [render_page description]
     *
     * @method render_page
     *
     * @param  [type]      $view [description]
     * @param  [type]      $data [description]
     *
     * @return [type]            [description]
     */
    protected function render_page($view, $data)
    {
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/main_header', $this->data);
        $this->load->view('templates/main_sidebar', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('templates/footer', $this->data);
        $this->load->view('templates/control_sidebar', $this->data);
    }
}
