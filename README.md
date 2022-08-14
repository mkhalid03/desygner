# Project Installation

Execute following commands

First, [download this repo](https://github.com/mkhalid03/desygner).

    git clone git@github.com:mkhalid03/desygner.git

Enter to the project.

    cd desygner

Build the Docker images:

    docker-compose build --no-cache --pull

Start the project!

    docker-compose up -d

Connect to the **PHP** bash

    docker exec -it desygner_php /bin/sh

Execute migrations

    bin/console doctrine:migrations:execute 'DoctrineMigrations\Version20220510085530'--up

Generate the SSL keys

    bin/console lexik:jwt:generate-keypair --overwrite

Browse https://localhost, your Docker configuration is ready!

> **_NOTE:_**  Please confirm `127.0.0.1 localhost` exists in hosts file


