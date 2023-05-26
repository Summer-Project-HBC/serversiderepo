## follow the command

-> first clone the repository to your local folder
git clone repositoryAddress

-> delete summerProject containers from docker if exist

-> change the yml file if you want, I already have changed it, so it will not conflict with existing containers

->Create .env file at the root and copy the following in your env file-
DATABASE_NAME=summerProjectDB
DATABASE_USERNAME=root
DATABASE_PASSWORD=pass

->Then run the command docker compose up -d (ensure that docker is running and stop all other running containers)

-> Go to web folder (cd web)

-> create a .env file and copy the content of .env.example to this .env file

-> then run command docker exec -it summerprojectId /bin/sh (you can copy from docker container also)

-> cd web

-> php bin/console make:migration

-> php bin/console doctrine:migrations:migrate

-> add some data in database(phpMyAdmin Page) for checking

## Following steps are not necessary

-> if web is not there Create a new symfony project with command - symfony new web

-> Go to web folder..cd web and add a .env file and copy the content of .env.example to .env file

-> composer require symfony/maker-bundle

-> composer require symfony/twig-bundle

-> composer require doctrine/orm

-> composer require doctrine

-> php bin/console make:entity

-> set table name as Events, property name: title(string, 250, no),picture(string, 250, yes),duration(integer, no),info(text, 250),date(date, no),time(time, no),location(string, 250, no),transport(string, 250, no)

-> docker exec -it projectDockerId /bin/sh (you can copy from docker container also)

-> cd web

-> edit the env file in web folder (DATABASE_URL="mysql://root:pass@summerProjectDB:3306/summerProjectDB?serverVersion=5.7"
)
-> php bin/console make:migration

-> php bin/console doctrine:migrations:migrate
