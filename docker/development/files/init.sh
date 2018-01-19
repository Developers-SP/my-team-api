#!/bin/bash
# -----------------------------------------------------------------------------
# Initialize
# -----------------------------------------------------------------------------
/usr/sbin/init

# -----------------------------------------------------------------------------
# Initialize cron job
# -----------------------------------------------------------------------------
/usr/sbin/crond

# -----------------------------------------------------------------------------
# APACHE SETTINGS
# -----------------------------------------------------------------------------
APACHE_LOG_DIR="/var/log/httpd"
APACHE_LOCK_DIR="/var/lock/httpd"
APACHE_RUN_USER="apache"
APACHE_RUN_GROUP="apache"
APACHE_PID_FILE="/var/run/httpd/httpd.pid"
APACHE_RUN_DIR="/var/run/httpd"

# -----------------------------------------------------------------------------
# APACHE FOLDER'S
# -----------------------------------------------------------------------------
if ! [ -d /var/run/httpd ]; then mkdir /var/run/httpd;fi
if ! [ -d /var/log/httpd ]; then mkdir /var/log/httpd;fi
if ! [ -d /var/lock/httpd ]; then mkdir /var/lock/httpd;fi

# -----------------------------------------------------------------------------
# APACHE LOG
# -----------------------------------------------------------------------------
touch $APACHE_LOG_DIR/access_log
touch $APACHE_LOG_DIR/error_log
chown apache. $APACHE_LOG_DIR/*

# -----------------------------------------------------------------------------
# Initialize Apache
# -----------------------------------------------------------------------------
#httpd -X -D FOREGROUND & tail -f $APACHE_LOG_DIR/*
httpd -X -D FOREGROUND
