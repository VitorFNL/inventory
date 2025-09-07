# 📦 Inventory Management System

Sistema de gerenciamento de inventário desenvolvido com Laravel 12, utilizando Docker para containerização e integração com a Fake Store API.

## 🛠️ Pré-requisitos

Antes de rodar a aplicação, certifique-se de ter instalado:

- [Docker](https://www.docker.com/get-started) (versão 20.0 ou superior)
- [Docker Compose](https://docs.docker.com/compose/install/) (versão 2.0 ou superior)
- [Git](https://git-scm.com/) para clonar o repositório

## 📋 Instalação e Configuração

### 1. Clone o Repositório

```bash
git clone https://github.com/VitorFNL/inventory
cd inventory
```

### 2. Configuração de Ambiente

Copie o arquivo de ambiente e configure as variáveis:

```bash
# No Windows
copy .env.example .env

# No Linux/Mac
cp .env.example .env
```

### 3. Subir os Containers Docker

```bash
docker-compose up --build -d
```

Isso irá criar e iniciar os seguintes containers:
- **inventory_php_fpm**: Aplicação Laravel (PHP 8.4-fpm-alpine)
- **inventory_nginx**: Servidor web Nginx
- **inventory_postgres**: Banco de dados PostgreSQL 17

### 4. Instalar Dependências do Composer

```bash
docker exec inventory_php_fpm composer install
```

### 5. Executar Migrações e Seeders

```bash
docker exec inventory_php_fpm php artisan migrate:fresh --seed
```

## 🌐 Acessando a Aplicação

Após a configuração, a aplicação estará disponível em:

- **URL:** http://localhost:8000
- **Usuário de Teste:** (criado pelo seeder)
  - Email: `admin@example.com`
  - Senha: `password`

## 🔌 API Endpoints

### Autenticação
- `GET /login` - Página de login
- `POST /login` - Realizar login
- `POST /logout` - Realizar logout

### Dashboard
- `GET /dashboard` - Listagem de produtos com filtros
- `GET /dashboard?nameFilter=produto&descriptionFilter=desc&priceOrderFilter=asc` - Filtros aplicados

### Sincronização
- `POST /api/products/sync` - Sincronizar com Fake Store API

### Produtos
- `PUT /api/products/{id}` - Atualizar produto específico, os campos devem ser passados no corpo da requisição