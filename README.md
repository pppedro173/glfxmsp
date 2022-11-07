glfxmsp is a take home assignment, that motivated me to build a mini-framework and an Api to book and create classes.

Installation / Usage
--------------------

Download and install Composer by following the [official instructions](https://getcomposer.org/download/).

Download and install PHP 7.2.5 or above (all tests and development were done with php 7.4.28).

    Run composer install

    Run composer dump-autoload

Open a public server: 

    php -S localhost:8000 -t public

Call any of the public endpoints (Postman and curl were used to test the endpoints and produce endpoint documentation) according to the documentation bellow

<p align="center">
    <a href="https://user-images.githubusercontent.com/34283375/200284316-80ba62d7-111e-488e-93ba-327d41c6330d.png">
        <img src="https://user-images.githubusercontent.com/34283375/200284316-80ba62d7-111e-488e-93ba-327d41c6330d.png" alt="doc1">
    </a>
</p>

<p align="center">
    <a href="https://user-images.githubusercontent.com/34283375/200284333-08d3e7d8-a1a8-4634-92ec-36a44abe159c.png">
        <img src="https://user-images.githubusercontent.com/34283375/200284333-08d3e7d8-a1a8-4634-92ec-36a44abe159c.png" alt="doc2">
    </a>
</p>

Tests
-------

- PHP UNIT was used for testing.

- A script was created to generate a full coverage report, just run 

    composer-run-unit-tests 
    
and a reports directory will be generated with all the details.

- IMPORTANT NOTE: Runing the unit tests cleans the Db file (creates an empty Db type setting).

Requirements
------------

#### Latest Composer

PHP 7.2.5 or above for the latest version.

#### Composer 2.2 LTS (Long Term Support)

PHP versions 5.3.2 - 8.1 are still supported via the LTS releases of Composer (2.2.x). If you
run the installer or the `self-update` command the appropriate Composer version for your PHP
should be automatically selected.

Authors
-------

- Pedro Soares  | [GitHub](https://github.com/pppedro173)
