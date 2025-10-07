<?php

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Formatter\Compressed;

$scssDir = WCRQ_PATH . 'assets/scss';
$cssDir = WCRQ_PATH . 'assets/css';

$compiler = new Compiler();
$compiler->setFormatter(Compressed::class);

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($scssDir));
$scssFiles = new RegexIterator($iterator, '/^.+\.scss$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($scssFiles as $file) {
  $scssFile = $file[0];
  $cssFile = $cssDir . '/' . pathinfo($scssFile, PATHINFO_FILENAME) . '.css';

  $scssContent = file_get_contents($scssFile);
  $cssContent = $compiler->compile($scssContent);

  file_put_contents($cssFile, $cssContent);
}

foreach ($scssFiles as $file) {
  $scssFile = $file[0];
  $cssFile = $cssDir . '/' . pathinfo($scssFile, PATHINFO_FILENAME) . '.css';

  $lastModified = filemtime($scssFile);

  $scssContent = file_get_contents($scssFile);
  $cssContent = $compiler->compile($scssContent);

  file_put_contents($cssFile, $cssContent);
}
