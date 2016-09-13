<?php

return array(
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => array('address' => "{{}}", 'name' => "{your name}"),
    'encryption' => 'tls',
    'username' => "{your email address}",
    'password' => "{your gmail password}",
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
);