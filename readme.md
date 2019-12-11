## Comandos de execução
```
docker run --rm -v $(pwd):/app prooph/composer:7.2 install
cp .env.example .env
docker-compose up -d
```

## Write permissions on folders
```
mooven/storage/logs
mooven/storage/framework
```

Address to access the App: http://localhost

## Endpoints
```
GET    | api/users/{username}
GET    | api/users/{username}/repos
POST   | api/users
POST   | api/users/{username}/repos
```
Endpoints pre-registered
```
GET    | api/users/testeSilva
GET    | api/users/testeSilva/repos
```

## Running tests
```
docker exec -it mooven_php_1 bash
./vendor/bin/phpunit
```
PS: change the name 'mooven_php_1' if your path is different