<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * @package    ClassMgt(Click-AP)-core
 * @author     Martin <martin@click-ap.com>
 * @copyright  2023 Click-AP {@link https://www.click-ap.com}
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @since      Version 3.2.0
 *
 */

class AdminController extends MI_Controller
{
    public $CI;

    /**
     * An array of variables to be passed through to the view, layout, ....
     */
    protected $data = array();

    protected $theme = 'common2/admin'; //'reactadmin/admin'; // 'common2/admin2';

    protected $role_id;

    protected $site = 'admin';

    protected $session_id;

    protected $user;

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // CI profiler
        $this->output->enable_profiler(false);

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        //$CI =& get_instance();

        $this->load->library('smarty_acl');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model(array(
            'system/setting_model',
            'system/user_model',
            'system/menu_model',
            'system/account_role_model',
            'system/user_group_auth_model',
            'system/personal_authority_model',
        ));
        // 網站參數
        $this->data['_SETTING'] = $this->initSetting();
        // 傳送 josn 給 JavaScrip 使用
        $this->data['_JSON'] = array();
        // 提示訊息
        $this->initAlert();

        $this->session_id = $this->session->session_id;
        $_session = $this->session->userdata($this->site.$this->session_id);
        $user = $this->user_model->get(array('id' => $_session['member_userid']));
        if ($user) {
            $this->user = $user;
            $this->data['_USER'] = $user;
            $_usrnick= empty($user['co_usrnick']) ? $user['name'] : $user['co_usrnick'];
            $this->data['_USER']['usrnick'] = $_usrnick;
        }
        // 選單
        $this->initMenu();
        // 目前位置
        $this->setMenu($user, $_session['member_userid']);
        $this->setMenuLocation();
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
        $_theme = $this->theme;
        // CSRF Token
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
debugBreak();
        $data['_JSON']['_ALERT'] = $data['_ALERT'];
        $data = array_merge($this->data, $data);

        $_css = $this->load->view("{$_theme}/css.inc.php", $data, TRUE);
        $this->load->view("{$_theme}/header.inc.php", array('css' => $_css));
        
        $data['navbar'] = $this->load->view("{$_theme}/navbar.inc.php", $data, TRUE);
        $data['sidebar'] = $this->load->view("{$_theme}/sidebar.inc.php", $data, TRUE);

        //$data['__content'] = $this->load->view($view, $data, true);
        // 套用舊的style ==> wrapper
        $_content = $this->load->view($view, $data, true);
        $data['__content'] = $this->load->view("{$_theme}/wrapper.inc.php", array(
            '__wrapper' => $_content,
            '_LOCATION' => $data['_LOCATION']
        ), TRUE);

        $this->load->view("{$_theme}/index", $data); // navbar, sidebar, view

        $data['js'] = $this->load->view("{$_theme}/js.inc.php", $data, TRUE);
        $this->load->view("{$_theme}/footer.inc.php", $data); // footer, js
    }

    /********************************
     * Setting functions.
     ********************************/
    private function initSetting()
    {
        $data = array();
        $settings = $this->setting_model->getChoices();
        if ($settings) {
            $data = $settings;
        }
        return $data;
    }

    /********************************
     * Menu functions.
     ********************************/
    private function initMenu()
    {
        $this->data['_MENU'] = array();
        $this->data['menu_catalog'] = array();
        $this->data['menu_function'] = array();
        $this->data['menu_current'] = array();
        return $this;
    }

    private function setMenu($_user, $_userid)
    {
        $_permission = [];
        //$this->data['_MENU'] = $this->menu_model->getSidebarByPort($this->site);
        $userGroupId = $this->account_role_model->getByUsername($_user['username']);
        foreach($userGroupId as $key => $groupId){
            if($key == '0'){
                $_permission = $this->user_group_auth_model->getByGroupID($groupId);
            }else{
                $groupPermission = $this->user_group_auth_model->getByGroupID($groupId);
                if(!empty($groupPermission)){
                    $_permission = array_unique(array_merge($_permission, $groupPermission));
                }
            }
        }
        // 個人權限
        $userPermission = $this->personal_authority_model->getByUserID($_userid);
        if(!empty($userPermission)){
            $_permission = array_unique(array_merge($_permission, $userPermission));
        }
        $_allMenus = $this->menu_model->getSidebarByPort($this->site);
        $_accessMenus = [];
        foreach($_allMenus as $menu) {
            $_topMenu = [];
            if (in_array($menu['id'], $_permission) || $menu['auth'] == 0) { 
                $_topMenu = $menu;
                $_subMenus = [];
                if (count($menu['sub']) > 0) {
                    foreach($menu['sub'] as $subMenu) {
                        if (in_array($subMenu['id'], $_permission) || $subMenu['auth'] == 0) { 
                            array_push($_subMenus, $subMenu);
                        }
                    }
                    $_topMenu['sub'] = $_subMenus;
                }
                array_push($_accessMenus, $menu);
            }
        }
        $this->data['_MENU'] = $_accessMenus;
        return $_accessMenus;
    }

    private function setMenuLocation()
    {
        $this->data['_LOCATION'] = $this->menu_model->getLocation($this->site);
    }

    /********************************
     * Alert function.
     * param kind [int]
     * 0 => gary,
     * 1 => Green,
     * 2 => Blue,
     * 3 => Yellow,
     * 4 => Red
     ********************************/
    private function initAlert()
    {
        $this->data['_ALERT'] = array();

        $alert = $this->session->flashdata('_ALERT');
        if ($alert) {
            $this->data['_ALERT']['kind'] = $alert['kind'];
            $this->data['_ALERT']['message'] = $alert['message'];
            $this->data['_ALERT']['sec'] = $alert['sec'];
            $this->data['_ALERT']['layout'] = $alert['layout'];
        }
    }

    protected function setAlert($kind=0, $message=NULL, $sec=5 ,$layout='center')
    {
        $data = array(
            'kind' => $kind,
            'message' => $message,
            'sec' => $sec,
            'layout' => $layout,
        );
        $this->session->set_flashdata('_ALERT', $data);
    }
}
