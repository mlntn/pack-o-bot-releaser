# pack-o-bot release tool

### Installing

1. `git clone git@github.com:mlntn/pack-o-bot-releaser.git`
2. `composer install`
3. `cp .env.template .env`
4. Enter GitHub username and password in .env. Update pack-o-bot dist path, if necessary.

### Releasing

1. Build pack-o-bot
2. `php release.php {version} {description}`