# BerryBox Backend & Administration
Symfony app for ads management.

![Screenshot](./screenshot.jpg?raw=true)

## Built on
- Symfony 5.2.1
- PHP 7.1.25 - fpm
- Node v8.9.0

## Development

- Firstly, connect your Symfony app with DB in `.env.local` from `.env` file.

- Install dependencies:

```shell
$ composer install
```

- Start server:

```shell
$ symfony server:start
```

- Run migrations:

```shell
$ php bin/console doctrine:migrations:migrate
```

- Load fixtures:

```shell
$ php bin/console doctrine:fixtures:load
```

- Install node modules:

```shell
$ yarn install
```

- Run yarn watch:

```shell
$ yarn encore dev --watch
```

or just compile once:
```shell
$ yarn encore dev
```


### Administration login

- **Path:** `{SERVER}/admin`
- **Username:** `demo`
- **Password:** `demo`
