<?php defined('BASEPATH') or die();

class MY_Controller extends CI_Controller
{
    protected $option, $route, $url;
    public $scripts, $data;

    public function __construct()
    {
        parent::__construct();

        $this->_option();
        $this->_route();
        $this->data = $this->scripts = [];

        $this->theme($this->option['theme']);
    }

    private function _option()
    {
        /*
        $_options = $this->db->get('option')->result();

        if (count($_options) > 0) {
            foreach ($_options as $_option) {
                $this->option[$_option->option_key] = $_option->option_value;
            }
        }
        */

        $this->option['theme'] = isset($this->option['theme']) ? $this->option['theme'] : 'default';
    }

    private function _route()
    {
        if (method_exists($this->router, 'fetch_module'))
            $this->route['module'] = $this->router->fetch_module();
        $this->route['controller'] = $this->router->fetch_class();
        $this->route['action'] = $this->router->fetch_method();
    }

    private function _url()
    {
        $this->url['base'] = base_url();

        $this->url['self'] = $this->url['base'];
        if (isset($this->route['module']))
            $this->url['self'] .= $this->route['module'] . '/';
        $this->url['self'] .= $this->route['controller'] . '/';
        $this->url['self'] .= $this->route['action'] . '/';

        $this->url['theme'] = $this->url['base'] . "themes/{$this->option['theme']}/";
    }

    public function theme($theme)
    {
        if ($this->option['theme'] != $theme)
            $this->option['theme'] = $theme;

        $this->_url();
        $this->twig->set('route', $this->route);
        $this->twig->set('scripts', $this->scripts);
        $this->twig->set('url', $this->url);

        $this->twig->theme($this->option['theme']);

        return $this;
    }

    public function script($name, $url)
    {
        $this->scripts[$name] = $url;
        $this->twig->set('scripts', $this->scripts);

        return $this;
    }
}
