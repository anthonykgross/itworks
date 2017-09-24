# itworks
Description on going 

## Requirements
- PHP 7
- Yarn 
- MariaDB /MySQL

## How to install
- Define your Youtube API key in `app/config/parameters.dist.yml` as `youtube_api_key`
- Define your Youtube channel ID to crawl in `app/config/parameters.dist.yml` as `youtube_channel_id`
- Define your database credentials in `app/config/parameters.dist.yml`
- Run these following commands
```bash
composer install
yarn run newinstall
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console itworks:fixtures
php bin/console itworks:youtube:sync
```
- Log in as user: `admin`; password: `admin`

## Episode (French)
- [Playlist](https://www.youtube.com/playlist?list=PLCsa_8vz1nX55noFNC8hNQO6XgDhlV5x5)
- [Ep 01 : Spécifications du client et analyse des besoins](https://www.youtube.com/watch?v=pD5ugHBLzPA)
- [Ep 02 : La modélisation des données](https://www.youtube.com/watch?v=VNG24gdYZL8)
- [Ep 03 : Bundles et entités](https://www.youtube.com/watch?v=DiAzeqHMZrg)
- [Ep 04 : Dependency injection](https://www.youtube.com/watch?v=U2-71RdoE_U)

## Creator
**Anthony K GROSS**
- <http://anthonykgross.fr>
- <https://twitter.com/anthonykgross>
- <https://github.com/anthonykgross>

## Copyright and license
Code and documentation copyright 2017. Code released under [the MIT license](https://github.com/anthonykgross/itworks/blob/master/LICENSE).
