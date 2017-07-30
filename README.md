# Vault

Lightweight artifact manager.

Vault aims to use Nginx to serve content wherever possible to be as fast and efficient as possible.

## Setting up database

```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
chmod 0666 data/vault.db
```


## User management

https://symfony.com/doc/master/bundles/FOSUserBundle/command_line_tools.html

Creating the first user

php bin/console fos:user:create --super-admin 