#  Movie Database

The Movie Database is a web application built on Bootstrap, jQuery and LAMP stack built with Docker Compose.

It makes use of the MovieLens data (http://files.grouplens.org/datasets/movielens/ml-latest-small.zip) which consists of information about movies and ratings and tags of movies provided by viewers, etc. The system is intended to enable marketing professionals to analyse how audiences have responded to films that have been released, and to help them understand the market for films that they are planning. It is intended to help them better understand the different kinds of viewers of movies and their varying preferences. The core functions that your system should provide are these:

Use case / function:

- [x] Browsing films in the database (i.e., visual listings of films in the dataset, with user-modifiable views).
- [x] Searching for a film to obtain a report on viewer reaction to it (i.e., an interpreted report with aggregate viewer ratings,
etc.).
- [x] Reporting which are the most popular movies and which are the most polarising (extreme difference in ratings).
- [ ] Segmenting the audience for a released movie (i.e., identifying categories of viewer by the rating and tag data, also in
relation to data for ratings to all movies).
- [ ] Predicting the likely viewer ratings for a soon-to-be-released film based on the tags and or ratings for the film provided by
a preview panel of viewers drawn from the population of viewers in the database.
- [ ] Predicting the personality traits of viewers who will give a high rating to a soon-to-be-released film (using the
personality/ratings dataset from GroupLens) whose tags are known.

##  Installation
 
* Clone this repository on your local computer
* configure .env as needed
* Run the `docker-compose up -d`.

```shell
git clone https://github.com/qianhaochen/movie-database
cd movie-database/
docker-compose up -d
```

Your LAMP stack is now ready!! You can access it via `http://localhost`.

##  Configuration and Usage

### General Information 
This Docker Stack is build for local development and not for production usage.

### Configuration
This package comes with default configuration options. You can modify them by creating `.env` file in your root directory.
To make it easy, just copy the content from `sample.env` file and update the environment variable values as per your need.

### Configuration Variables
There are following configuration variables available and you can customise them by overwriting in your own `.env` file.

---
#### PHP
---
_**PHPVERSION**_
Is used to specify which PHP Version you want to use. Defaults always to latest PHP Version. 

_**PHP_INI**_
Define your custom `php.ini` modification to meet your requirements. 

---
#### Apache 
---

_**DOCUMENT_ROOT**_

It is a document root for Apache server. The default value for this is `./www`. All your sites will go here and will be synced automatically.

_**APACHE_DOCUMENT_ROOT**_

Apache config file value. The default value for this is /var/www/html.

_**VHOSTS_DIR**_

This is for virtual hosts. The default value for this is `./config/vhosts`. You can place your virtual hosts conf files here.

> Make sure you add an entry to your system's `hosts` file for each virtual host.

_**APACHE_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./logs/apache2`.

---
#### Database
---

_**MYSQL_DATA_DIR**_

This is MySQL data directory. The default value for this is `./data/mysql`. All your MySQL data files will be stored here.

_**MYSQL_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./logs/mysql`.

## Web Server

Apache is configured to run on port 80. So, you can access it via `http://localhost`.

#### Connect via SSH

You can connect to web server using `docker-compose exec` command to perform various operation on it. Use below command to login to container via ssh.

```shell
docker-compose exec webserver bash
```

## PHP

The installed version of depends on your `.env`file. 


## phpMyAdmin

phpMyAdmin is configured to run on port 8080. Use following default credentials.

http://localhost:8080/  
username: root  
password: tiger

## Redis

It comes with Redis. It runs on default port `6379`.

## Contributing
We are happy if you want to create a pull request or help people with their issues. If you want to create a PR, please remember that this stack is not built for production usage, and changes should good for general purpose and not overspecialised. 
Thank you! 
