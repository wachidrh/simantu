<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enable_options
{
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function enableCSRF()
    {
        if ($this->ci->config->item('csrf_protection') === false) {
            $uri = $this->ci->config->item('enable_csrf_for_uris_only');
            $segment = $this->ci->uri->segment('1');

            if (in_array($segment, $uri)) {
                $this->ci->config->set_item('csrf_protection', true);
                $this->ci->security->regenerate_csrf_hash();
            }
        }
    }
}
