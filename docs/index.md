# Index
---
## Overview
**InternshipManager** is a **fast**, **simple** and **efficient** php website, which allows you to manage internship offers. All this is made possible by the implementation of the MVC model and a quality code (not sure about this)

### Host anywhere
**InternshipManager** use php7 and PostreSQL to run, so if your machine has it you can use **InternshipManager**.

### Easy to configure
**InternshipManager** allows you to easily configure your use, using its simplistic configuration file

---

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
TODO - Jerem ecris ici le truc pour les email stp

---

## Getting Started
Once installed, all you have to do is configure your web host to access **InternshipManager** (we won't develop it here).