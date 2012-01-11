<?php

echo '<pre>';
require_once '../lib/Multimethod.php';

$m = multimethod()
    ->when('1', 'monocycle')
    ->when('2', 'bicycle')
    ->when('3', 'tricycle');

$func1 = $m->create();
foreach(range(0, 4) as $n)
    echo $func1($n), PHP_EOL;

echo '<hr/><br/>';

$m->setDefault('<i>...default...</i>');
$func2 = $m->create();
foreach(range(0, 4) as $n)
    echo $func2($n), PHP_EOL;

?>
