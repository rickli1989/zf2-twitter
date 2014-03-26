Zend Framework 2 Twitter User Timeline Feed
=======================

Introduction
------------
This is a simple, twitter application using the ZF2 MVC layer and module
systems to get the feed from a user and store it into database, finally using
Angular js ngTable to sort and filter in front-end.

Installation Using Git
----------------------
You need to an install using native git submodules:

    cd /User/{name}/public_html( which is your local lamp env directory)
    git clone https://github.com/rickli1989/zf2-twitter.git
    cd zf2-twitter/
    mv zf2/ ../zf2
    cd ../zf2
    php composer.phar self-update
    php composer.phar install

Database Setup
--------------
Copy and past the following code into /config/autoload/local.php with your localhost username and password.
If the file does not exists, created it.

    <?php
        /**
         * Local Configuration Override
         *
         * This configuration override file is for overriding environment-specific and
         * security-sensitive configuration information. Copy this file without the
         * .dist extension at the end and populate values as needed.
         *
         * @NOTE: This file is ignored from Git by default with the .gitignore included
         * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
         * credentials from accidentally being committed into version control.
         */

        return array(
            'db' => array(
                 'username' => 'yourusername',
                 'password' => 'yourpassword',
             )
        );
    ?>


Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-twitter.localhost
        DocumentRoot /path/to/zf2/public
        <Directory /path/to/zf2/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>


Database SQL Insert
-------------------

The sql file can be found in data.sql


Sameple Scrennshot
------------------
![alt tag](https://raw.githubusercontent.com/rickli1989/rickli1989.github.io/master/zf2/public/img/shot1.png)
![alt tag](https://raw.githubusercontent.com/rickli1989/rickli1989.github.io/master/zf2/public/img/shot2.png)
![alt tag](https://raw.githubusercontent.com/rickli1989/rickli1989.github.io/master/zf2/public/img/shot3.png)
