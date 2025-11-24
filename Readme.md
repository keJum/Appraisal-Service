# Service Appraisal

## Стек
 - PHP 8.4
 - Symfony 7.3
 - MySQL 8

# Разворачивание 
 1. `$ mv .env.example .env`
 2. В контейнере php из проекта Appraisal-Infrastructure выполнить `$ composer install`
 3. В контейнере php из проекта Appraisal-Infrastructure выполнить `$ php bin/console doctrine:migration:migrate`

# Тестирование
В контейнере php из проекта Appraisal-Infrastructure выполнить `$ php bin/phpunit`
