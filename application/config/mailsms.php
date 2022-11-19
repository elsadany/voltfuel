<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// Config variables

$config['mailsms'] = array(

);
$config['smtp_encryption'] = array(
    '' => 'OFF',
    'ssl' => 'SSL',
    'tls' => 'TLS',
);

$config['smtp_auth'] = array(
    'true' => 'ON',
    'false' => 'OFF'
);


$config['perm_category'] = array('can_view', 'can_add', 'can_edit', 'can_delete');

