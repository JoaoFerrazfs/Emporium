<h1 align="center"> Projeto Emporium</h1>
<p align="center"> Plataforma de Ecommerce</p>

## Descrição do Projeto 

Este projeto busca implementar uma plataforma simples e acessível para uso de pequenos comércios.  

O sistema permitirá o controle de estoque, clientes, produtos, vendas  e além de guardar o histórico de vendas dos produtos.

## :hammer: Funcionalidades Principais

- **Gerenciamento de Usuários**
- **Catálogo de Produtos**
- **Gerenciamento de Vendas**
- **Controle de Estoque**
- **Confirmação via E-mail**
- **Validações de Usuário**
- **Funcionalidades Disponibilizadas via APIs**

## :white_check_mark: Tecnologias Utilizadas

- **PHP 8**
- **Laravel 10**
- **Laravel Octane**
- **Swoole**
- **SQLite**
- **Redis**
- **Bootstrap**
- **GitHub Actions**
- **API de Pagamentos do Mercado Pago**
- **PHPMD**
- **PHPCS**

## 🌐 Acesso ao Site em funcionamento
[Emporium](http://emporiumecommerce.duckdns.org)

## Instruções de Instalação

### O projeto esta configurado para ser funcional utilizando o docker:

```bash
`docker compose build`
`docker compose up -d`
`docker compose exec app php artisan key:generate`
```

### Foi adicionado ao projeto seed pra produtos e usuários, caso quera utilize o comando:
```bash
docker compose exec app php artisan db:seed
```

Credenciais para acesso
| Email                     | Senha         |
|---------------------------|---------------|
| joaoferrazp@gmail.com     | 12345678      |
| jpferrazsoares@gmail.com  | 12345678      |


## Instruções para Execução Local

Depois do projeto iniciado o acesso será feito pela url: http://localhost:8000/

## Licença

Este projeto é licenciado sob a [Licença MIT](LICENSE).
