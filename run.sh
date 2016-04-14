#!/usr/bin/env bash

service php5-fpm restart && service nginx restart

echo "Press [CTRL+C] to stop.."

while :
do
	sleep 1
done
