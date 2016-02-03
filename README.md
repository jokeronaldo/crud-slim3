# CRUD

Crud simples com Slim 3 Framework

## Instalação

```bash
$ git clone https://github.com/jokeronaldo/crud-slim3.git
$ composer install
```

Rodar o dump do banco de dados **crud.sql**

## Configurações

Alterar configurações de banco entre outras no arquivo **src/settings.php**

Dar permissão de escrita no diretório logs

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
