
### Passo a passo
Necessário Docker instalado, nodeJs

Suba os containers do projeto
```sh
docker-compose up -d
```
Crie o Arquivo .env
```sh
cp .env.example .env
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
```sh
php artisan db:seed
```
Usuário adm :
email = admin@dkluizz.com
password = admin123456

Executar node
```sh
npm install
npm run build
```
```sh
npm run dev
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)
