FROM nginx:1.15.8

LABEL maintainer="jorin.vermeulen@gmail.com"

#Add required user
RUN useradd -m -G audio shoutzor

#Add required groups for pulseaudio
RUN groupadd --system pulse && \
groupadd --system pulse-access && \
useradd --system -g pulse -G audio -d /var/run/pulse -m pulse -s /bin/bash

RUN apt-get update && apt-get upgrade -y

#Install required system packages
RUN apt-get install -y \
nano \
sudo \
curl \
gnupg2 \
gcc \
g++ \
make \
sudo \
htop \
dbus \
libasound2 \
libasound2-plugins \
alsa-utils \
alsa-oss

#Install required applications for shoutzor (except mysql)
RUN apt-get install -y \
php7.0-fpm \
php7.0-mysql \
pulseaudio \
darkice \
icecast2

#Add permissions for our own accounts to access PulseAudio
RUN usermod -G audio,video,pulse,pulse-access shoutzor && \
usermod -G audio,video,pulse,pulse-access www-data

#Install Tizonia (for spotify, etc via command-line)
RUN curl -kL https://github.com/tizonia/tizonia-openmax-il/raw/master/tools/install.sh | bash -

#Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - && \
apt-get install -y nodejs

#Configure PHP-FPM for nginx, as well as enable PHP-FPM on boot
RUN sed -i 's/listen.owner = www-data/listen.owner = nginx/g' /etc/php/7.0/fpm/pool.d/www.conf && \
sed -i 's/listen.group = www-data/listen.group = nginx/g' /etc/php/7.0/fpm/pool.d/www.conf && \
sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php/7.0/fpm/php.ini && \
mkdir /run/php && \
/etc/init.d/php7.0-fpm start

#Copy our config files
COPY persistence /

#Copy our website files
COPY www /usr/share/nginx/html

#Copy the NodeJS app files
WORKDIR /usr/src/app
COPY node-app /usr/src/app
RUN npm install --verbose && \
chown -R shoutzor:shoutzor /usr/src/app

#Copy our start script
COPY ./start.sh /
CMD /start.sh

#Expose the required ports

#nginx
EXPOSE 80
EXPOSE 443

#Icecast2
EXPOSE 8000

#NodeJS
EXPOSE 8080