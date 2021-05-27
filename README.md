# Data Importer

This application allows to import necessary customers from a data provider like `randomuser.me`.

## Requirements

- Docker - https://docs.docker.com/get-docker/
- Docker Compose - https://docs.docker.com/compose/install/
- VSCode (Optional) - https://code.visualstudio.com/download

## How to run

1. Clone the repository and change directory

```cmd
git clone https://github.com/mikekael/data-importer.git && cd data-importer
```

2. Run the server

```cmd
docker-compose up -d
```

3. Install application dependencies

```cmd
docker-compose exec app composer install
```

4. Execute migration files

```cmd
docker-compose exec app php artisan doctrine:migrations:migrate
```

5. Run the importer command

```cmd
docker-compose exec app php artisan import:customers
```

Once you have completed the necessary steps you can now access the api via `http://localhost:8080/customers`

## Running the test

```cmd
docker-compose exec app php vendor/bin/phpunit
```