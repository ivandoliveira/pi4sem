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

Este documento explica como rodar o projeto **ecommerce_api** usando o **XAMPP** no Windows e como importar a **collection do Insomnia** usada para testar a API.

---

## 🧩 1. Pré-requisitos

* XAMPP instalado (Apache + MySQL)
* Projeto dentro de **htdocs**
* Banco **ecommerce.sql**
* Insomnia instalado

---

## 📁 2. Estrutura do Projeto

```
C:\xampp\htdocs\
 ├── ecommerce_api
 ├── ecommerce.sql
 ├── img/
 ├── dashboard/
 ├── xampp/
 ├── index.php
```

---

## 🚀 3. Como rodar o projeto

### ✔️ Iniciar os serviços

Abra o XAMPP e inicie:

* **Apache**
* **MySQL**

---

### ✔️ Acessar o projeto

```
http://localhost/ecommerce_api
```

---

## 🗄️ 4. Importar o Banco de Dados

1. Acesse phpMyAdmin:

   ```
   http://localhost/phpmyadmin
   ```
2. Clique em **Importar**
3. Selecione **ecommerce.sql**
4. Clique em **Executar**

---

## ⚙️ 5. Configurar a Conexão com o Banco

Em arquivos como `config.php`, verifique:

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecommerce";
```

---

# 🧪 6. Collection do Insomnia

```json
{
  "resources": [
    {
      "type": "folder",
      "name": "Usuário",
      "resources": [
        {
          "type": "request",
          "name": "Criar Usuário",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/usuario/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "loginUsuario": "edu_artesao",
            "senha": "senha123",
            "nome": "Eduardo Costa",
            "perfil": "C"
          }
        },
        {
          "type": "request",
          "name": "Consultar Produtos do Usuário",
          "method": "GET",
          "url": "http://localhost/ecommerce_api/api/usuario/consulta_produtos_usuario.php",
          "headers": [
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ]
        }
      ]
    },
    {
      "type": "folder",
      "name": "Cliente",
      "resources": [
        {
          "type": "request",
          "name": "Criar Cliente",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/cliente/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "nome": "Maria Cliente",
            "email": "maria@cliente.com",
            "senha": "senhasegura123",
            "cpf": "123.456.789-00",
            "celular": "(11) 98765-4321",
            "dataNascimento": "1990-05-15"
          }
        },
        {
          "type": "request",
          "name": "Login Cliente",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/cliente/login.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "email": "franciniassisdev@gmail.com",
            "senha": "123456"
          }
        },
        {
          "type": "request",
          "name": "Criar Endereço",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/endereco/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "idCliente": 1,
            "nomeEndereco": "Casa Principal",
            "logradouro": "Rua das Flores",
            "numero": "123 B",
            "cep": "01000-000",
            "cidade": "São Paulo",
            "uf": "SP",
            "complemento": "Apto 101"
          }
        }
      ]
    },
    {
      "type": "folder",
      "name": "Produto",
      "resources": [
        {
          "type": "request",
          "name": "Criar Produto",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/produto/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "nomeProduto": "Brincos de Malaquita",
            "precProduto": 89.90,
            "idUsuario": 2,
            "idCategoria": 2,
            "qtdMinEstoque": 5
          }
        },
        {
          "type": "request",
          "name": "Consultar Todos os Produtos",
          "method": "GET",
          "url": "http://localhost/ecommerce_api/api/produto/consulta_todos_produtos.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ]
        },
        {
          "type": "request",
          "name": "Consultar Produtos por Categoria",
          "method": "GET",
          "url": "http://localhost/ecommerce_api/api/produto/consulta_produto_por_categoria.php",
          "parameters": [
            {"name": "idCategoria", "value": "1"}
          ],
          "headers": [
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ]
        }
      ]
    },
    {
      "type": "folder",
      "name": "Pedido",
      "resources": [
        {
          "type": "request",
          "name": "Criar Pedido",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/pedido/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "idCliente": 1,
            "idTipoPagto": 2,
            "idAplicacao": 2,
            "idEndereco": 1,
            "idStatus": 1,
            "itens": [
              {
                "idProduto": 1,
                "qtdProduto": 1,
                "precoVendaItem": 99.90
              }
            ]
          }
        },
        {
          "type": "request",
          "name": "Consultar Pedido por Cliente",
          "method": "GET",
          "url": "http://localhost/ecommerce_api/api/pedido/consulta_pedido_usuario.php",
          "parameters": [
            {"name": "idCliente", "value": "3"}
          ],
          "headers": [
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ]
        }
      ]
    },
    {
      "type": "folder",
      "name": "Categoria",
      "resources": [
        {
          "type": "request",
          "name": "Criar Categoria",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/categoria/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "nome": "Madeira",
            "descricao": "Objetos de decoração e utensílios entalhados."
          }
        }
      ]
    },
    {
      "type": "folder",
      "name": "Tipo Pagamento",
      "resources": [
        {
          "type": "request",
          "name": "Criar Tipo de Pagamento",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/tipopagamento/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "idTipoPagto": 2,
            "descTipoPagto": "Crédito"
          }
        }
      ]
    },
    {
      "type": "folder",
      "name": "Aplicação",
      "resources": [
        {
          "type": "request",
          "name": "Criar Aplicação",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/aplicacao/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "idAplicacao": 2,
            "DescAplicacao": "Web",
            "TipoAplicacao": "W"
          }
        }
      ]
    },
    {
      "type": "folder",
      "name": "Status Pedido",
      "resources": [
        {
          "type": "request",
          "name": "Criar Status de Pedido",
          "method": "POST",
          "url": "http://localhost/ecommerce_api/api/statuspedido/create.php",
          "headers": [
            {"name": "Content-Type", "value": "application/json"},
            {"name": "User-Agent", "value": "insomnia/12.0.0"}
          ],
          "body": {
            "idStatus": 1,
            "descStatus": "Pedido Recebido"
          }
        }
      ]
    }
  ]
}
```

---

## 📥 Como importar a Collection no Insomnia

1. Abra o **Insomnia**
2. Clique em **Application → Import → From File**
3. Selecione o arquivo `insomnia-collection.json`
4. A rota aparecerá automaticamente na sua workspace

---

# 📝 7. Possíveis Problemas

### ❗ Apache não inicia

* Portas ocupadas (80 ou 443)
* Fechar Skype, IIS, VMware, WSL
  ou
* Alterar a porta em `httpd.conf`

### ❗ MySQL não conecta

* Usuário padrão: `root`
* Senha: *(vazia)*

---

# ✔️ 8. Finalização

Com tudo configurado, você pode testar a API pelo navegador ou pelo Insomnia usando a collection importada.

---