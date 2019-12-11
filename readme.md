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