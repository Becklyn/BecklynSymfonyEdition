Becklyn Symfony Edition
=======================

This is a fork of the [Symfony Standard Edition](https://github.com/symfony/symfony-standard), that automatically adds typical configuration settings as used by Becklyn.


Installation
------------

```bash
$ composer create-project becklyn/symfony-edition path
```


Running in production
---------------------

You need to define three environment variables:

Environment variable name     | Description
----------------------------- | ------------------
`SYMFONY__DATABASE__USER`     | database user name
`SYMFONY__DATABASE__PASSWORD` | database password
