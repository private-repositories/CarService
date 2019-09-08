
# Car Service Demo

## Overview

The service is written using the PHP framework I am most familiar with (SLIM) and is based on my generic SlimBase project, which includes generic CRUD route handling for models

## The Brief

See the [original brief](brief.md), as supplied

## Tools

It uses a variety of tools, mostly familiar to me:

- [Phinx](https://phinx.org/)
- [Slim v3](https://www.slimframework.com/)
- [Eloquent ORM](https://www.slimframework.com/docs/v3/cookbook/database-eloquent.html)
- [DotEnv](https://github.com/vlucas/phpdotenv)
- [Postgres 11](https://www.postgresql.org/)
- [PHP](http://php.net/)
- [Vagrant](https://www.vagrantup.com/)
- [Apache](https://httpd.apache.org/)
- [PHPUnit](https://phpunit.de/)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [Postman](https://www.getpostman.com/)
- [Swagger](https://swagger.io)

Api Running Instructions are to be found below.

## Server Running Instructions - Vagrant

Requires Vagrant and a Virtualisation Engine

https://www.vagrantup.com/downloads.html
https://www.virtualbox.org/wiki/Downloads

Once installed, you can navigate to the root directory of this project (with the VagrantFile), and run
```
vagrant up
```
This will provision a vagrant server with ubuntu, php, postgres, apache and the slim framework. It will also create and seed the database, and bring in the composer dependencies.

There will be a lot of commands executed, with information shown in red or green. There shouldn't be anything to worry about, but the check is whether you reach the 'Vagrant Up' message, and there are no exit codes reported.

If anything untoward occurs, please let me know.

All being well, it will allow you to curl to the api and start making requests. Further instructions can be found below.

## Server Running Instructions - Other

To set this up without vagrant requires a few hoops to create the expected environment - a postgres db with the required roles and db, composer run to pull down the dependencies, and so on. If necessary these steps can be determined from the VagrantFile.

## Source

This service is based on my SlimBase repositort, which in turn is ultimately based on:

https://github.com/tuupola/slim-api-skeleton

NOTE: The work on SlimBase is not complete, so many aspects could be improved, or refactored.


## Limitations / Further Work

As this work was done over a short period of time, there will always be areas to improve following a review. There were sacrifices meet the initial deadline, which means that some aspects are not 100% complete.

Naturally, I could have continued with this, but had to draw a line somewhere.

Some incomplete areas or future work are:
 - Lookup tables - for model, fuel type, transmission
 - Validation for year of purchase - not in the future
 - Regex validation for registration
 - Split owner's company into a separate table
 - Assume owner name is unique index

## Server Running Instructions

To SSH onto the running server, from the directory root use:

```
vagrant ssh
```

The URL is 192.168.50.52

The postgres database details are:
- User: carservicedbuser
- PW: thisisnotasecurepassword
- DB: vagrant
- Schema: carservice

(Internal to vagrant server)

## API Running Instructions
