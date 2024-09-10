
### Passo a passo para rodar esse projeto
Clone Repositório
```sh
git clone -b https://github.com/MarceloPereiraAntonio/Solar_energy_project.git
```
```sh
cd name your project
```

Suba os containers do projeto
```sh
docker-compose up -d
```
Crie o Arquivo .env
```sh

cp .env.example .env
```
Atualize essas variáveis de ambiente no arquivo .env
```dosini

APP_NAME="Solar_energy_project"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=Laravel
DB_USERNAME=user
DB_PASSWORD=root

# Variáveis para configuração do Swagger UI
# L5_SWAGGER_UI_DARK_MODE: Define se o modo escuro está ativado para a interface Swagger UI. 
# false - Modo claro (padrão).
# true  - Modo escuro.

# L5_SWAGGER_GENERATE_ALWAYS: Se definido como true, gera a documentação Swagger sempre que rodar o comando "php artisan L5-swagger:generate"
L5_SWAGGER_UI_DARK_MODE=false
L5_SWAGGER_GENERATE_ALWAYS=true
```
Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Rodar as migrations
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)

Para acessar a documentação do projeto acesse
[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)
