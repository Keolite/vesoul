# Vesoul

vesoul is a symfony project built to replace an old e-commerce site owned by a
french book label called [vesoul-edition](https://vesouledition.fr/).


## Install

**Download or clone the repository**

```bash
git clone https://github.com/n3wborn/vesoul.git
```


**Get in the git repo and install dependencies**

```bash
cd vesoul && composer install && yarn install
```


**Note**: If you're a Vagrant (or another virtal environment) user, consider trying
**--no-bin-links** yarn option if problems were encountered during install.


Edit **.env** (or better, create a .env.local) file to update variables needed
to access the dbms.

**Note**:

You can follow the next step to build the project but there's a more convenient way.
Check out [prepare section](https://github.com/n3wborn/vesoul/blob/main/README.md#prepare)


**Create the database**

```bash
php bin/console doctrine:database:create
```


**Prepare to migrate database**

```bash
php bin/console make:migration
```


**Migrate**

```bash
php bin/console doctrine:migrations:migrate
```


**Next, if you want fixtures**

```bash
php bin/console doctrine:fixtures:load
```


**Let Webpack build the assets**

```bash
yarn build
```


**During development, keep watching your files and compile when needed with**

```bash
yarn run watch
```


## Prepare

If you look at composer.json you'll see 2 scripts, prepare and prepare-test.
Thanks to this, it will be easier to prepare dev and test environment.

**prepare dev environment** :

```bash
composer prepare"
```


**prepare test environment** :

```bash
composer prepare-test"
```

**This will recreate the database and fixtures, so stop wasting your time**.

Note : **Don't forget that you have to configure Symfony environment !**.

You can replace DATABASE_URL and MAILER_URL into .env and .env.test if you want.
But you can also override it using .env.local and .env.test.local.
Moreover, these ones are not committed (Symfony add them in .gitignore).

## Conclusion

Now, you're ready to go. Check user fixtures if you want to log in (as a user
or as the administrator). If you're not using fixtures, you must create an
administrator (ie: ['ROLE_ADMIN']) by hand and insert a bcrypt hash for it's
password. You can get one using php from cli with :

```bash
php -r "echo password_hash('ThePassword', PASSWORD_BCRYPT) . PHP_EOL;"
$2y$10$SzgYG0QZh8TcW851Q.ADru.lOtngwYGsnx.crY4ls64ILP2qyY0oK
```
