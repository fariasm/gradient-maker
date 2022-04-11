# Gradient Maker

This is a simple css gradient generator.

Backend was developed with Laravel, use MySQL as database software and frontend was build with Angular.

## Installation
The installation tool kit include:

- Nginx web server for API.
- MySQL used for templates database.
- phpMyAdmin interface to connect to your MySQL database.

You can deploy locally using docker compose command in repository root folder.

Clone this repo and follow these steps:

1. Run docker compose up command:

```sh
docker-compose up -d --build
```

2. Run composer install inside api container:

```sh
docker-compose exec api composer install
```

3. Run npm update inside app folder:

```sh
cd app;
npm update;
```

4. Finally, serve Angular application.

```sh
ng serve -o
```

## API documentation

API specification was build with [darkaonline/l5-swagger](https://github.com/DarkaOnLine/L5-Swagger), a Swagger integration package for Laravel.

You can access to documentation at: `http://localhost:{api_port}/api/docs`

## Continuous integration

[ci-laravel.yml](.github/workflows/ci-laravel.yml) define the jobs needed to perform unit testing and allow push to main branch only if all tests succeed.



