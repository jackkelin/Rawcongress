## About
---
## Instalation instructions

### First-time setup

Run `composer install` to create homestead dev files.

Install laravel/homstead vm `vagrant box add laravel/homestead`

Duplicate homestead.yaml.example file, remove .example extension on duplicated file. Run `php vendor/bin/homestead make`

Read Homestead.yaml for local env set up. Edit your /etc/hosts file to match ip and alias(listed under sites > map). 