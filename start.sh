#!/bin/bash

#Start required services
/etc/init.d/php7.2-fpm start

#Start the DBus daemon
/etc/init.d/dbus start

#Start the pulseaudio daemon
/etc/init.d/pulseaudio start

#Start our audio stream
/etc/init.d/icecast2 start

#Start Darkice
sudo PULSE_RUNTIME_PATH=/var/run/pulse -u pulse /usr/bin/darkice &

#Run our nodeJS app as the same shoutzor user
#cd /usr/src/app && su -c "npm start" -s /bin/bash shoutzor

#Start nginx in the foreground in order to keep this container running
/usr/sbin/nginx -g "daemon off;"