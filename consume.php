<?php

use kkchaulagain\phpQueue\Consumer;

require 'vendor/autoload.php';


$config =[
    'queue'=>'test',
    'vhost'=>'/'
];

Consumer::consume($config);