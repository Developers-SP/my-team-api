# -----------------------------------------------------------------------------
# CentOS-7, Apache 2.2, PHP 7.2.1
# -----------------------------------------------------------------------------
FROM centos:7

# -----------------------------------------------------------------------------
# Update distribution
# -----------------------------------------------------------------------------
RUN yum -y update; yum clean all

# -----------------------------------------------------------------------------
# Install Apache
# -----------------------------------------------------------------------------
RUN yum -y --setopt=tsflags=nodocs install httpd

# -----------------------------------------------------------------------------
# Configure PHP using custom VirtualHost configuration
# -----------------------------------------------------------------------------
ADD ./docker/development/files/virtualhost.conf /etc/httpd/conf.d/virtualhost.conf

# -----------------------------------------------------------------------------
# Install remi's repository
# -----------------------------------------------------------------------------
RUN yum -y install wget
RUN rpm -ivh  https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -ivh http://rpms.remirepo.net/enterprise/remi-release-7.rpm

# -----------------------------------------------------------------------------
# Install PHP 7.0.12 from remi's repository
# -----------------------------------------------------------------------------
RUN yum --enablerepo=remi --enablerepo=remi-test -y install \
  php70 \
  php70-php \
  php70-php-common \
  php70-php-cli \
  php70-php-devel \
  php70-php-gd \
  php70-php-mbstring \
  php70-php-mcrypt \
  php70-php-pecl-memcached \
  php70-php-mysqlnd \
  php70-php-pdo \
  php70-php-pgsql \
  php70-php-pecl-zip \
  php70-php-intl \
  php70-php-xml; \
  yum clean all
# RUN -y install php71w-php-pecl-xdebug.x86_64 
# -----------------------------------------------------------------------------
# Copy php.ini configs
# -----------------------------------------------------------------------------
COPY ./docker/development/files/php.ini /etc/opt/remi/php70/php.ini

# -----------------------------------------------------------------------------
# Creating symbolic link between php-7 to php for compatibility
# -----------------------------------------------------------------------------
RUN ln -s /usr/bin/php70  /usr/bin/php

# -----------------------------------------------------------------------------
# Install NewRelic
# -----------------------------------------------------------------------------
#RUN rpm -Uvh http://yum.newrelic.com/pub/newrelic/el5/x86_64/newrelic-repo-5-3.noarch.rpm
#RUN yum -y install newrelic-php5 newrelic-install install
#RUN echo 'newrelic.license="290194fef51e6d3e758837279628a337810cfa48"' >> /etc/opt/remi/php71w/php.ini

# -----------------------------------------------------------------------------
# Install Systemd
# -----------------------------------------------------------------------------
RUN yum -y install systemd; yum clean all;
RUN (cd /lib/systemd/system/sysinit.target.wants/; for i in *; do [ $i == systemd-tmp./docker/development/files-setup.service ] || rm -f $i; done); \
rm -f /lib/systemd/system/multi-user.target.wants/*;\
rm -f /etc/systemd/system/*.wants/*;\
rm -f /lib/systemd/system/local-fs.target.wants/*; \
rm -f /lib/systemd/system/sockets.target.wants/*udev*; \
rm -f /lib/systemd/system/sockets.target.wants/*initctl*; \
rm -f /lib/systemd/system/basic.target.wants/*;\
rm -f /lib/systemd/system/anaconda.target.wants/*;

# -----------------------------------------------------------------------------
# Install Cron
# -----------------------------------------------------------------------------
RUN yum install -y cronie;

# -----------------------------------------------------------------------------
# Copy Cron config
# -----------------------------------------------------------------------------
COPY ./docker/development/files/cron.conf /var/spool/cron/root
RUN chmod 600 /var/spool/cron/root

# -----------------------------------------------------------------------------
# Set Environment & Work dir
# -----------------------------------------------------------------------------
ARG env
RUN echo "export APP_ENV=$env" >> /etc/environment
WORKDIR /api/

# -----------------------------------------------------------------------------
# EXPOSE PORT 80
# -----------------------------------------------------------------------------
EXPOSE 80

# -----------------------------------------------------------------------------
# Volumes cgroup
# -----------------------------------------------------------------------------
VOLUME [ "/sys/fs/cgroup" ]

# -----------------------------------------------------------------------------
# Init Bash
# -----------------------------------------------------------------------------
ADD ./docker/development/files/init.sh  /usr/bin/init.sh
RUN chmod -v +x /usr/bin/init.sh

# -----------------------------------------------------------------------------
# Execute init.sh on container start
# -----------------------------------------------------------------------------
CMD ["/usr/bin/init.sh"]
#ENTRYPOINT ["/usr/bin/init.sh"]
#ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
