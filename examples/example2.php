<?php

echo '<pre>';
require_once '../lib/Multimethod.php';

class Movie {
    public $name, $genre;
    public function __construct($name, $genre) {
        $this->name = $name;
        $this->genre = $genre;
    }
}

$m = multimethod()
    ->dispatch('genre')
    ->when('horror', 'run! run! run!')
    ->when('sci-fi', 'are you a nerd?')
    ->setDefault(function($input) {
        return 'undefined genre: '.$input;
    })
    ->create();

echo $m(new Movie('Friday the 13th', 'horror')), PHP_EOL;

echo $m(new Movie('Star Wars', 'sci-fi')), PHP_EOL;

echo $m(new Movie('Twilight', 'shit')), PHP_EOL;
?>
