# challenge-alura-back-end-4

Projeto desenvolvido durante Challenge da Alura usando [Symfony 5.4](https://symfony.com/doc/5.4/setup.html) e PHP 7.3.5. 

## Rotas

### Receitas
| Rota | Método | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| /receitas | POST | Cadastra uma receita | <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04"<br>} </pre> | - |
| /receitas | GET | Retorna todas as receitas | - | descricao (opcional) |
| /receitas/{ano}/{mes} | GET | Retorna todas as receitas do mês | - | - |
| /receitas/{id} | GET | Retorna receita por id | - | - |
| /receitas/{id} | PUT | Atualiza receita por id | <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04"<br>} </pre> | - |
| /receitas/{id} | DELETE | Remove receita por id | - | - |

### Despesas
| Rota | Método | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| /despesas | POST | Cadastra uma despesa |  <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04",<br> "id_categoria": 1<br>} </pre> O campo id_categoria é opcional | - |
| /despesas | GET | Retorna todas as despesas | - | descricao (opcional) |
| /despesas/{ano}/{mes} | GET | Retorna todas as despesas do mês | - | - |
| /despesas/{id} | GET | Retorna despesas por id | - | - |
| /despesas/{id} | PUT | Atualiza despesa por id |  <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04",<br> "id_categoria": 1<br>} </pre> O campo id_categoria é opciona | - |
| /despesas/{id} | DELETE | Remove despesa por id | - | - |

### Resumo
| Rota | Método | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| /resumo/{ano}/{mes} | GET | Retorna resumo do mês | - | - |

### Para criar um projeto no symfony para api
```
composer create-project symfony/skeleton:"^5.4" challenge-alura-back-end-4
```

### Para inicializar o servidor
```
php -S localhost:8080 -t public
```

### Para instalar o pacote de anotações
```
composer require annotation
```

### Instalando pacote de ORM (Doctrine)
```
composer require symfony/orm-pack
```

### Criando o banco
```
php bin\console doctrine:database:create
```

Antes é preciso alterar as configurações no arquivo .ENV

### Instalar componente maker do Symfony
```
composer require maker
```

### Listar tudo o que pode ser feito com maker
```
php bin\console list make
```

### Criar uma entidade
```
php bin\console make:entity
```

### Criar migration
```
php bin/console make:migration
```

### Rodar migration
```
php bin\console doctrine:migrations:migrate
```

### Criar controller
```
php bin\console make:controller
```
