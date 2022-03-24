# Coding Challenge

This is a coding challenge for the role senior backend engineer in Flexisource IT company.

## Requirements

- Docker - https://docs.docker.com/get-docker/
- Docker Compose - https://docs.docker.com/compose/install/
- VSCode (Optional) - https://code.visualstudio.com/download
- VsCode Remote Containers Extension

## How to run

1. Clone the repository and change directory

```cmd
git clone https://github.com/mikekael/data-importer.git && cd data-importer
```

2. Run the server

```cmd
docker-compose -f docker-compose.prod.yml -p data-importer_prod up  -d
```

3. Install dependencies

```cmd
docker-compose -f docker-compose.prod.yml \
    -p data-importer_prod \
    exec app \
    composer install
```

4. Run Migration

```cmd
docker-compose -f docker-compose.prod.yml \
    -p data-importer_prod \
    exec app \
    php bin/console doctrine:migration:migrate --no-interaction
```

5. Execute Importer

```cmd
# Run importer
docker-compose -f docker-compose.prod.yml \
    -p data-importer_prod \
    exec app \
    php bin/console importer:import-customers
```

6. Once its complete you can now access the api endpoints for the customers under http://localhost:8080
    - `/customers` - list of customers
    - `/customers/{customerId}` - retrieve customer data based on its identity
    - `/` - redirects to `/customers`

## Running Tests

1. Build a test environment containers. The purpose of this is to have a different database and avoid
populating your local database.

```cmd
docker-compose -f docker-compose.test.yml -p data-importer_test up  -d
```

2. Install dependencies

```cmd
docker-compose -f docker-compose.test.yml \
    -p data-importer_test \
    exec app \
    composer install
```

3. Execute the migration
```cmd
docker-compose -f docker-compose.test.yml \
    -p data-importer_test \
    exec app \
    php bin/console doctrine:migration:migrate --no-interaction
```

4. Run the tests
```cmd
docker-compose -f docker-compose.test.yml \
    -p data-importer_test \
    exec app \
    php bin/phpunit
```

## Developing

You may need to install vscode and remote containers extension in order to start the development process. If you have the vscode setup and remote containers installed press `ctrl+shift+p` to open the command pallete and choose the `Reopen Folder in the container` it should prompt you with the file manager and just press enter and it should build the environment using the `.devcontainer` configurations. Once the environment is built. You need to run the migration command and import the customers.