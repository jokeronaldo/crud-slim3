[![SensioLabsInsight](https://insight.sensiolabs.com/projects/39f9efdc-883e-40a8-a1ed-6d48203759f6/big.png)](https://insight.sensiolabs.com/projects/39f9efdc-883e-40a8-a1ed-6d48203759f6)
# CRUD SLIM 3

* **en:** Simple CRUD - Slim 3 Framework / Eloquent ORM / Monolog
* **pt-BR:** Crud simples com Slim 3 Framework / Eloquent ORM / Monolog

## Installation / Instalação

```bash
$ git clone https://github.com/jokeronaldo/crud-slim3.git
$ composer install
```

* **en:** Run database dump **crud.sql**
* **pt-BR:** Rodar o dump do banco de dados **crud.sql**

## Configurations / Configurações

**en:**

Change database configurations and others in **src/settings.php** file

Give write permissions on logs directory

Create **.htaccess** file in **public/** directory with the following content:

```
RewriteEngine On
RewriteRule .* - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```
---
**pt-BR:**

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

* **en:** All POST/PATCH requests must be done with **x-www-form-urlencoded**
* **pt-BR:** Todas requests de POST/PATCH devem ser feitas com **x-www-form-urlencoded**

## Routes / Rotas

#### Clubes (it means clubs)
* **GET** /clubes
* **GET** /clubes/{id}
* **GET** /clubes/{id}/usuarios
* **POST** /clubes
* **PATCH** /clubes/{id}
* **DELETE** /clubes/{id}

#### Planos (it means plans)
* **GET** /planos
* **GET** /planos/{id}
* **GET** /planos/{id}/usuarios
* **POST** /planos
* **PATCH** /planos/{id}
* **DELETE** /planos/{id}

#### Usuários (it means users)
* **GET** /usuarios
* **GET** /usuarios/{id}
* **GET** /usuarios/{id}/dependentes
* **POST** /usuarios
* **PATCH** /usuarios/{id}
* **DELETE** /usuarios/{id}

## TODO

**en:**

* Tests
* Change PATCH verbs to PUT
* Refactor methods to get data from json body (actually getting from x-www-form-urlencoded)
---
**pt-BR:**
* Testes
* Alterar verbos de PATCH para PUT
* Refatorar métodos para pegar dados do json body (atualmente pegando x-www-form-urlencoded)
