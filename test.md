./vendor/bin/phpunit --clear-cache

# Pruebas
./vendor/bin/phpunit tests/Application/UseCase/RegisterUserTest.php
./vendor/bin/phpunit tests/Domain/Event/UserRegisteredTest.php
./vendor/bin/phpunit tests/Integration/RegisterUserIntegrationTest.php

./vendor/bin/phpunit tests/Infrastructure/Presentation/Controller/RegisterUserControllerTest.php

# Cobertura
./vendor/bin/phpunit --coverage-html coverage

# Ver cantidad de memoria
php -i | grep memory_limit
