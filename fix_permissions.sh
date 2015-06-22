#!/bin/bash

if [ -z $APACHE_GRP ]; then
    echo -n "Apache Group: "
    read APACHE_GRP
fi

sudo chgrp -R $APACHE_GRP app/{logs,cache}
sudo chmod -R g+w app/{logs,cache}
sudo chmod -R g+s app/{logs,cache}

if groups | grep &>/dev/null "\b$APACHE_GRP\b"; then
    echo "Current user is in apache group";
else
    echo "WARNING: Current user is NOT in apache group";
fi