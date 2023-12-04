<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Security extends CI_Security
{
    public function regenerate_csrf_hash()
    {
        // CSRF config
        foreach (array('csrf_expire', 'csrf_token_name', 'csrf_cookie_name') as $key) {
            if (false !== ($val = config_item($key))) {
                $this->{'_' . $key} = $val;
            }
        }

        // Append application specific cookie prefix
        if (config_item('cookie_prefix')) {
            $this->_csrf_cookie_name = config_item('cookie_prefix') . $this->_csrf_cookie_name;
        }

        // Set the CSRF hash
        $this->_csrf_set_hash();
        $this->csrf_set_cookie();
    }
}
