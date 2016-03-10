[![SensioLabsInsight](https://insight.sensiolabs.com/projects/39f9efdc-883e-40a8-a1ed-6d48203759f6/big.png)](https://insight.sensiolabs.com/projects/39f9efdc-883e-40a8-a1ed-6d48203759f6)
# CRUD

Crud simples com Slim 3 Framework / Eloquent ORM / Monolog

## Instalação

```bash
$ git clone https://github.com/jokeronaldo/crud-slim3.git
$ composer install
```

Rodar o dump do banco de dados **crud.sql**

## Configurações

Alterar configurações de banco entre outras no arquivo **src/settings.php**

Dar permissão de escrita no diretório logs

Criar o arquivo **.htaccess** no diretório **public/** com o seguinte conteúdo:

```
RewriteEngine On
RewriteRule .* - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```

## API Request

Todas requests de POST/PATCH devem ser feitas com **x-www-form-urlencoded**

## Rotas

#### Clubes
* **GET** /clubes
* **GET** /clubes/{id}
* **GET** /clubes/{id}/usuarios
* **POST** /clubes
* **PATCH** /clubes/{id}
* **DELETE** /clubes/{id}

#### Planos
* **GET** /planos
* **GET** /planos/{id}
* **GET** /planos/{id}/usuarios
* **POST** /planos
* **PATCH** /planos/{id}
* **DELETE** /planos/{id}

#### Usuários
* **GET** /usuarios
* **GET** /usuarios/{id}
* **GET** /usuarios/{id}/dependentes
* **POST** /usuarios
* **PATCH** /usuarios/{id}
* **DELETE** /usuarios/{id}
