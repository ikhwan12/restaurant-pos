<?php
    class MyClass
    {
    function MyFunction()
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $config['hostname'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = '';
        $config['database'] = 'suprek';
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $CI->load->database($config);
        
    }
    }