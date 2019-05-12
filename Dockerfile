FROM nginx:1.15.8

LABEL maintainer="jorin.vermeulen@gmail.com"

#Add required user and required groups for pulseaudio
RUN useradd -m -G audio shoutzor && \
	groupadd --system pulse && \
	groupadd --system pulse-access && \
	useradd --system -g pulse -G audio -d /var/run/pulse -m pulse -s /bin/bash

#Disable interactive mode to prevent package install issues
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

#Install required system packages
RUN apt-get update && \
	apt-get upgrade -y && \
	apt-get install -y \
	bash \
	nano \
	sudo \
	curl \
	wget \
	gnupg2 \
	gcc \
	g++ \
	make \
	sudo \
	htop \
	dbus \
	apt-utils \
	libasound2 \
	libasound2-plugins \
	alsa-utils \
	alsa-oss \
	apt-transport-https \
	zip \
	unzip

#Add PHP 7.2, Phalcon and NodeJS PPA
RUN wget -q https://packages.sury.org/php/apt.gpg -O- | sudo apt-key add - && \
	echo "deb https://packages.sury.org/php/ stretch main" | sudo tee /etc/apt/sources.list.d/php.list && \
	curl -s "https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh" | /bin/bash && \
	curl -sL https://deb.nodesource.com/setup_11.x | bash -

#Install required applications for shoutzor (except mysql)
RUN apt-get update && \
	apt-get install -y \
	php7.2-fpm \
	php7.2-mysql \
	php7.2-dom \
	php7.2-phalcon \
	pulseaudio \
	darkice \
	icecast2 \
	nodejs

#Install PHPUnit for tests
RUN curl -L 'https://phar.phpunit.de/phpunit-7.phar' > /usr/bin/phpunit && \
    chmod a+x /usr/bin/phpunit

#Add permissions for our own accounts to access PulseAudio
RUN usermod -G audio,video,pulse,pulse-access shoutzor && \
	usermod -G audio,video,pulse,pulse-access www-data

#Install Tizonia (for spotify, etc via command-line)
RUN curl -kL https://github.com/tizonia/tizonia-openmax-il/raw/master/tools/install.sh | bash -s -- --safe

#Configure PHP-FPM for nginx, as well as enable PHP-FPM on boot
RUN sed -i 's/listen.owner = www-data/listen.owner = nginx/g' /etc/php/7.2/fpm/pool.d/www.conf && \
	sed -i 's/listen.group = www-data/listen.group = nginx/g' /etc/php/7.2/fpm/pool.d/www.conf && \
	sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php/7.2/fpm/php.ini && \
	mkdir /run/php && \
	/etc/init.d/php7.2-fpm start

#Clean up
RUN apt-get autoremove -y && \
    apt-get autoclean -y && \
    apt-get clean -y

#Copy our config files
COPY persistence /

#Copy our website files
COPY www /usr/share/nginx/html

#Install composer
COPY ./install_composer.sh /
RUN chmod +x /install_composer.sh && \
sh /install_composer.sh

#Install composer dependencies
WORKDIR /usr/share/nginx/html/
RUN composer install && \
chown -R shoutzor:shoutzor /usr/share/nginx/html/vendor

#Copy the NodeJS app files
WORKDIR /usr/src/app
COPY node-app /usr/src/app
RUN npm install --verbose && \
chown -R shoutzor:shoutzor /usr/src/app

#Copy our start script
COPY ./start.sh /
RUN chmod 777 /start.sh
CMD ["/bin/bash", "/start.sh"]

#Expose the required ports

#nginx
EXPOSE 80
EXPOSE 443

#Icecast2
EXPOSE 8000

#NodeJS
EXPOSE 8080
