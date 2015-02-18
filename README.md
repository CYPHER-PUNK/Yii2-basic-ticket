Yii 2 Basic Application Ticket
================================

Развернуть веб-приложение на основе yii 2 с авторизацией пользователей.
На странице поле для ввода email, после заполнения пользователю высылается одноразовая ссылка.
После перехода по ссылке, если пользователь не зарегистрирован, создается учетная запись и
пользователь авторизуется, в противном случае просто авторизуется.
Авторизованный пользователь попадает в личный кабинет, где может изменить имя и разлогиниться.


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      migrations/         contains DB migrations
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------
~~~
php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta4"
php composer.phar install
yii migrate/up --interactive=0
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.
