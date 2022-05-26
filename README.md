# doomtrooperdb-wordpress

Built with [WordPlate](https://github.com/wordplate/wordplate).

## Install

```bash
make install
```

Edit the newly created `.env` file with the database name and WordPress salts.

## Docker

Start Docker:

```bash
make up
```

Access the site via https://localhost/ and [Adminer](https://www.adminer.org/) via http://localhost:8080/.

### WP-CLI

[WP-CLI](https://wp-cli.org/) can be run through Docker:

```bash
docker-compose run --rm wpcli help
docker-compose run --rm wpcli core version
```

## Quality assurance

### Code syntax

```bash
composer run lint
```

