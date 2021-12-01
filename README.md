# Sistema_Pizzaria

Guia Rápido que o projeto seja iniciado em seu ambiente


1. execute um git clone do projeto em um servidor local (APACHE, XAMPP, etc..).

2. Execute os comandos dentro da pasta ./backend/bd_crud/database.sql para criar o banco de dados.

3. Depois do banco de dados criado vamos realizar as devidas modificações no arquivo ./backend/bd_crud/crud.php.

private $db_host = "localhost"; // HOST Banco de Dados

private $db_user = "root"; // Usuário do Banco de Dados

private $db_pass = " "; // Senha do Usuario do Banco de dados

private $db_name = "Pizzaria"; // Nome do Banco de Dados

4. Depois de rodar todos os comandos de sql teremos 2 formas de fazer login.
4.1 Login como visitante que não terá todas as funções disponíveis.
4.2 Login como administrador que terá acesso a todas funções.

5. Login como visitante você será automaticamente redirecionado para realiza-lo.

6. Login como administrador você terá que acessar manualmente pela url que ao invés de ser login.php será loginAdmin.php

6.1 E-mail : admin@gmail.com

6.2 Senha: admin

