#!/bin/bash
cd /app/apache2/htdocs 
cp docker_templates/setup.php.docker /app/apache2/htdocs/setup.php
sudo apachectl -D FOREGROUND
