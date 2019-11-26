# README

## Installation
### Require
To use **InternshipManager** you must use php7 and a PostgreSQL database<br/>
Check that the line `extension=pdo_pgsql` in your *php.ini* is enabled

### Installation Tool
To install **InternshipManager** you must configure the file `config.php` in the directory `install` at the root of the project.<br/>
You have one configuration part for the database and the other for the administrator account, on the site.<br/>
<br/>
When you configure your file run in a terminal (at project directory)
```shell
php install.php
```
If your configuration is good you will see the message `Installation done!`, else check your config and try again.

### Warning
The installation tool does not create a database in postgreSQL, you must create a user and a database to be able to use it. (Installation tool only create database schema).

### Mail interface
To run **InternshipManager** on your machine, an SMTP client is required to send mail. **InternshipManager** sends mail to the admin when a new company account is created and to the company when the account is validated.<br/>
If you just want to try our service, you can easily install and setup [MSMTP](https://help.ubuntu.com/community/msmtp) on your linux to work with PHP.

---

## Documentation
### Require
To generate the documentation for **InternshipManager** you must use the [*Mkdocs*](https://www.mkdocs.org/).

### Build
To build the documentation open a terminal in the root of the project and do the command `mkdocs build`.
Once the documentation has been generated, you can access it in the directory /site