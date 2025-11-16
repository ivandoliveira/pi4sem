Perfeito! Aqui está o **README completo**, já atualizado com os nomes dos integrantes do grupo:

---

# 📘 Projeto Ecommerce API – README

## 👥 Integrantes do Grupo

* **Carolina Pereira Lopes**
* **Ivan de Oliveira Pereira**
* **Jocemarina Rabelo da Rosa Marangone Marque**
* **Rafael Aguiar Sanchietta**
* **Vitor Manoel Felipe da Silva**

---

# 🛒 Ecommerce API – Documentação do Ambiente Local

Este documento explica como rodar o projeto **ecommerce_api** usando o **XAMPP** no Windows.

---

## 🧩 1. Pré-requisitos

* **XAMPP** instalado (Apache + MySQL)
* PHP já incluído no XAMPP
* Projeto dentro da pasta `htdocs`
* Arquivo de banco de dados `ecommerce.sql`

---

## 📁 2. Estrutura do Projeto (conforme a pasta enviada)

```
C:\xampp\htdocs\
 ├── ecommerce_api      ← pasta do projeto
 ├── ecommerce.sql      ← banco de dados
 ├── index.php
 ├── img/
 ├── dashboard/
 ├── xampp/
 ...
```

---

## 🚀 3. Como rodar o projeto

### ✔️ 3.1 Iniciar o XAMPP

1. Abra o **XAMPP Control Panel**
2. Clique em **Start** nos seguintes serviços:

   * Apache
   * MySQL

Os dois devem aparecer em **verde**, indicando que estão rodando.

---

### ✔️ 3.2 Acessar o projeto

No navegador, abra:

```
http://localhost/ecommerce_api
```

Se a pasta tiver um arquivo `index.php`, ele será carregado automaticamente.

---

## 🗄️ 4. Configurar o Banco de Dados

### ✔️ 4.1 Importar o banco de dados

1. Acesse:

   ```
   http://localhost/phpmyadmin
   ```
2. Clique em **Importar**
3. Selecione o arquivo:

   ```
   ecommerce.sql
   ```
4. Clique em **Executar**

O banco será criado e as tabelas importadas.

---

## ⚙️ 5. Verificar a conexão com o banco

Localize o arquivo de configuração do banco (ex.: `config.php`, `database.php` ou similar) e confirme:

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecommerce";
```

---

## ▶️ 6. Testar a API / Sistema

Após iniciar o servidor e importar o banco, acesse as rotas ou páginas disponibilizadas pelo projeto.

---

## 📝 7. Possíveis Problemas e Soluções

### ❗ Apache não inicia

* Outro programa está usando a porta 80 ou 443
  Exemplos: Skype, IIS, VMware, WSL
  Solução:
* Fechar o programa que está usando a porta
  ou
* Alterar a porta do Apache:
  `XAMPP > Apache > Config > httpd.conf`

### ❗ Erro ao conectar ao MySQL

* Verificar usuário e senha
* No XAMPP, o padrão é:

  * usuário: **root**
  * senha: *(vazia)*

---

## ✔️ 8. Projeto pronto!

Com Apache + MySQL rodando e o banco importado, seu ambiente local do **Ecommerce API** estará funcionando.

---

Se quiser, posso também criar:
📌 Um README separado só para a API
📌 Um README para o repositório geral
📌 Passo a passo de rotas, endpoints, ou documentação estilo Swagger

Só pedir!
