# Big Band Biskupská Web App
Web app for Big Band Biskupská

## Build information
[![Build Status](https://travis-ci.org/bigbandbiskupska/bigbandbiskupska.svg?branch=master)](https://travis-ci.org/bigbandbiskupska/bigbandbiskupska)


## Development

Start the app using docker:

```bash
docker-compose up
```

The server will be ready at http://localhost:8000

TODO:
 * you need to copy the sample local config neon
 * you need to import the sample data from tests/db/init.sql

## Server install

```
# change the directory to the web server's document root
$ cd document_root
# clone the repository
$ git clone https://github.com/bigbandbiskupska/bigbandbiskupska
$ cd bigbandbiskupska
# run composer install/update
$ composer install
# fill local configuration (e. g. database)
$ cp app/config/sample.config.local.neon app/config/config.local.neon
$ nano app/config/config.local.neon
# change rights on directories for web server
$ sudo chown -R "$USER":www-data temp
$ sudo chown -R "$USER":www-data log
$ sudo chmod -R g=u temp
$ sudo chmod -R g=u log
# you're ready to run
$ wget http://localhost/.../bigbandbiskupska
```