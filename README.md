Workshop "Inside the Symfony 2 DIC and Config" - PHPBenelux 2013
================================================================

This is the codebase to get you started with the Symfony DIC workshop
at PHPBenelux 2013. Please make sure to follow these steps before
attending the workshop:

1. Check requirements
---------------------

Your system needs to cover the general requirements for a Symfony 2.2.x installation, see
[http://symfony.com/doc/current/reference/requirements.html](http://symfony.com/doc/current/reference/requirements.html).

In addition, please make sure to have cUrl and its PHP extension installed and enabled for
both the webserver and the command line.

2. Install
----------

Clone this repository:

    $ git clone git@github.com:meandmymonkey/phpbnl13-workshop.git
    $ cd phpbnl13-workshop

Install composer:

    $ curl -s http://getcomposer.org/installer | php

Use Composer to install vendor libraries:

    $ php composer.phar install

3. Check requirements again :)
------------------------------

    $ php app/check.php

Everything in the "Mandatory requirements" section of the output should be flagged as OK.

4. Try it
---------

Calling

    $ php app/console ecb:exchangerates

should now list current exchange rates on the command line.

Notes
-----

This exercise is command line only - there is no valid controller to use in a web environment.
