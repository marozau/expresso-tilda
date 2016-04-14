#!/usr/bin/env bash

docker run --name nginx-expresso -p 80:80 -v /home/docker/nginx:/home/docker/nginx -d -it nginx-php
