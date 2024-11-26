# Intro
Sometimes I want to test the latest tech or some other things I've found on the web.
This project is based on the free to use api [Spacetraders.io](spacetraders.io) and uses some of the endpoins.

I'm testing frontend things, playing around with Twig Components or other things that I like to see working (or try to get it to work).

## Symfony Docker
I'm using the official  [Symfony Docker Image](https://github.com/dunglas/symfony-docker)

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

### License

Symfony Docker is available under the MIT License.

## Get Started
### Assumptions
* Docker is up and runing
* Docker compose works to
* Port 80 is not in use

### Setup
1. Clone this repo `git clone git@github.com:florian25686/spacetrader.git`
2. Inside the folder run `docker compose up -d` to start the container
3. Connect into the running container `docker exec -ti symfony-docker-php-1 bash`
4. Run `composer install`
5. Open your browser and point it to `localhost`
6. Accept the certificate
