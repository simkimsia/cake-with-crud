<?php

$path_to_file = 'app/Controller/AppController.php';
$file_contents = file_get_contents($path_to_file);

$patterns = array();
$replacements = array();

// this places App::uses('CrudControllerTrait' .. after the App::uses('Controller' ..
$search = "App::uses('Controller', 'Controller');";
$replace = $search . "\nApp::uses('CrudControllerTrait', 'Crud.Lib');";
$escaped_search = escape_special_characters($search);
$patterns[] = '/' . $escaped_search . '/';
$replacements[] = $replace;

// this places use CrudControllerTrait; after class AppController extends Controller {
$search = "class AppController extends Controller {";
$replace = $search;
$replace .= "\n\n\tuse CrudControllerTrait;\n\n";
// and include the components as well
$replace .= "\tpublic \$components = array(\n";
$replace .= "\t\t'Crud.Crud' => array(\n";
$replace .= "\t\t\t'actions' => array(\n";
$replace .= "\t\t\t\t'index', 'add', 'edit', 'view', 'delete'\n";
$replace .= "\t\t\t)\n";
$replace .= "\t\t)\n";
$replace .= "\t);\n";

$escaped_search = escape_special_characters($search);
$patterns[] = '/' . $escaped_search . '/';
$replacements[] = $replace;

$file_contents = preg_replace($patterns, $replacements, $file_contents);

file_put_contents($path_to_file,$file_contents);

// copy and paste the Model, Controller and View files for Post
copy('default_files/Controller/PostsController.php', 'app/Controller/PostsController.php');
copy('default_files/Model/Post.php', 'app/Model/Post.php');
recurse_copy('default_files/View/Posts', 'app/View/Posts');

// add CakePlugin::loadAll(); to last line of bootstrap
$path_to_file = 'app/Config/bootstrap.php';
$file_contents = file_get_contents($path_to_file);
$file_contents .= "\nCakePlugin::loadAll();\n";
file_put_contents($path_to_file,$file_contents);

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

function escape_special_characters($search) {
  $special_characters = array(
    ".", "^", "$", 
    "*", "+", "?",
    "(", ")", "[",
    "{", "|", "\\"
  );

  $character_array = str_split($search);
  $string_array = array();
  foreach ($character_array as $character) {
    if (in_array($character, $special_characters)) {
      $string_array[] = "\\";
    }
    $string_array[] = $character;
  }

  return implode("", $string_array);

}