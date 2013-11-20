#!/bin/bash

# remove any traces of cakephp before we clone
rm -Rf cakephp

# clone the latest cakephp master branch
git clone git@github.com:cakephp/cakephp.git

# remove the app, lib, index.php and plugins folders
rm -Rf app
rm -Rf lib
rm -Rf index.php
rm -Rf plugins

# copy out the latest app, lib, index.php, and plugins folders
cp -R cakephp/app .
cp -R cakephp/lib .
cp cakephp/index.php .
cp -R cakephp/plugins .

# change the permissions to 777
chmod -R 777 app/tmp

# remove the cloned cakephp
rm -Rf cakephp