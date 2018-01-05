<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

/**
 * 在控制器之前，验证相关信息
 */
$hook['post_controller_constructor'] = array(
    'class'    => 'Hook',
    'function' => 'post_controller_constructor',
    'filename' => 'Hook.php',
    'filepath' => 'hooks',
);
