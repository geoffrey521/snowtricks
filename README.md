# Initialise project

## Versions
* PHP 8.0
* Symfony 5.4.1
* Doctrine 2.10.4
* Postgresql 13

## Requirement
* PHP
* Symfony 
* Docker
* Composer
* yarn

## Steps

1. Clone the project repository

````
git clone https://github.com/geoffrey521/snowtricks.git
````

2. Download and install Composer dependencies

```
composer install
```

3. Download and install packages dependencies

````
yarn install
````

or

````
npm install
````

4. Build from asset

````
yarn watch
````

5. Using Database from docker

Make sure docker is running, run:

````
docker-compose up
````