#!/bin/bash

# remove any traces of crud before we clone
rm -Rf plugins/Crud

# clone the latest cakephp master branch
git clone git@github.com:FriendsOfCake/crud.git plugins/Crud
