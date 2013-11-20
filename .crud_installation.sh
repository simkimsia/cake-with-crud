#!/bin/bash

# this bash script will work in LINUX ONLY. NOT MAC!
# only caters for php5.4

# this follows the instructions in 
# http://friendsofcake.com/crud/docs/installation.html#_php_54
match="App::uses('Controller', 'Controller');"
insert="App::uses('CrudControllerTrait', 'Crud.Lib');"
file="app/Controller/AppController.php"

sed -i "s/$match/$match\n$insert/" $file

match="class AppController extends Controller {"
insert="use CrudControllerTrait;"

sed -i "s/$match/$match\n\n\t$insert\n/" $file