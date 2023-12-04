<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('generate_recaptcha_form')) {
    function generate_recaptcha_form()
    {
        $CI = &get_instance();
        $site_key = $CI->config->item('google_recaptcha_site_key');
        return "<div class='g-recaptcha' data-sitekey='{$site_key}'></div>";
    }
}

if (!function_exists('verify_recaptcha')) {
    function verify_recaptcha($recaptcha_response)
    {
        $CI = &get_instance();
        $secret_key = $CI->config->item('google_recaptcha_secret_key');

        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $post_data = http_build_query(
            array(
                'secret' => $secret_key,
                'response' => $recaptcha_response
            )
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $verify_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        return $response->success;
    }
}
