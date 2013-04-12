agent
=====
Use Symfony 2.2.1, installed with vendors 
"php composer.phar create-project symfony/framework-standard-edition path/ 2.2.1"

В https://github.com/vinilzen/agent/blob/master/composer.json
добавлены SonataAdminBundle и FOSUserBundle с зависимостями. 
Установить их после обновления composer.json можно командой "php composer.phar update"

Настройки доступа к базе тут app/config/parameters.yml
