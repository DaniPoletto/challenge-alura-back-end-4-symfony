# challenge-alura-back-end-4

Projeto desenvolvido durante Challenge da Alura usando [Symfony 5.4](https://symfony.com/doc/5.4/setup.html) e PHP 7.3.5. 

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
