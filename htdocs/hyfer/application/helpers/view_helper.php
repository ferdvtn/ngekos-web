<?php

use eftec\bladeone\BladeOne;

if ( ! function_exists('view')) {
    function view($view, $data) {
        $views = APPPATH . '/views';
        $blade = new BladeOne($views, $views. '/cache', BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
        $blade->setBaseUrl(base_url());
        echo $blade->run($view, $data);
    }
}

/* End of file view_helper.php */
