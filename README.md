# Challenge Alura Back-end 4 edição

## O que é um challenge
São 4 semanas de desafios propostos pela plataforma de ensino Alura com o objetivo de praticar construindo um projeto. Toda semana são disponibilizados desafios e o aluno deve usar o material de apoio fornecido a cada semana para resolver o desafio proposto. 

## Projeto
Essa edição tem como objetivo construir uma api de controle financeiro. 

## Desafios de cada semana
<b>1ª semana</b> - CRUD de despesas e receitas e testes de api utilizando Postman

<b>2ª semana</b> - Categorização de despesas, filtro de despesas/receitas por descrição, listagem de despesas/receitas por mês, resumo do mês e testes automatizados

<b>3ª e 4ª semana</b> - Deploy e autenticação

## Tecnologias utilizadas
[Symfony 5.4](https://symfony.com/doc/5.4/setup.html), Doctrine e PHP 7.3.5. 

## URL Base
 > https://challenge-alura-4-2.herokuapp.com

## Rotas

### Autenticação
| Rota | Método | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| /login | GET | Retorna token obrigatório em todas as outras requisições | <pre>{<br>"usuario": "usuario",<br>"senha": "teste"<br>}</pre> | - |

O login e senha padrão são "usuario" e "senha". A autenticação é feita passando um Bearer Token como Authorization. 

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
| /despesas | POST | Cadastra uma despesa |  <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04",<br> "id_categoria": 1<br>} </pre> O campo id_categoria é opcional (ver ids correspondentes na tabela Categoria) | - |
| /despesas | GET | Retorna todas as despesas | - | descricao (opcional) |
| /despesas/{ano}/{mes} | GET | Retorna todas as despesas do mês | - | - |
| /despesas/{id} | GET | Retorna despesas por id | - | - |
| /despesas/{id} | PUT | Atualiza despesa por id |  <pre> {<br> "descricao": "Lanche",<br> "valor": 10.50,<br> "data": "2022-08-04",<br> "id_categoria": 1<br>} </pre> O campo id_categoria é opciona (ver ids correspondentes na tabela Categoria) | - |
| /despesas/{id} | DELETE | Remove despesa por id | - | - |

### Resumo
| Rota | Método | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| /resumo/{ano}/{mes} | GET | Retorna resumo do mês | - | - |

### Categorias disponíveis
| Nome | Id |
| --- | --- |
| Alimentação | 1 |
| Saúde | 2 |
| Moradia | 4 |
| Transporte | 5 |
| Educação | 6 |
| Lazer | 7 |
| Imprevistos | 8 |
| Outras | 3 |

### Instalando as dependências
```
composer install
```

### Criando o banco
```
php bin\console doctrine:database:create
```

### Rodando as migrations
```
php bin\console doctrine:migrations:migrate
```

### Inicializando o servidor
```
php -S localhost:8080 -t public
```

## Outros comandos que foram importantes para o desenvolvimento do projeto

### Para criar um projeto no symfony para api
```
composer create-project symfony/skeleton:"^5.4" challenge-alura-back-end-4
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
