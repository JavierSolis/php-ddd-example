./vendor/bin/phpunit --clear-cache

# Pruebas
./vendor/bin/phpunit tests/Application/UseCase/RegisterUserTest.php
./vendor/bin/phpunit tests/Domain/Event/UserRegisteredTest.php
./vendor/bin/phpunit tests/Integration/RegisterUserIntegrationTest.php
./vendor/bin/phpunit tests/Integration/DoctrineUserRepositoryTest.php
./vendor/bin/phpunit tests/Api/RegisterUserTest.php

./vendor/bin/phpunit tests/Domain/ValueObject/EmailTest.php
./vendor/bin/phpunit tests/Domain/ValueObject/NameTest.php
./vendor/bin/phpunit tests/Domain/ValueObject/PasswordTest.php
./vendor/bin/phpunit tests/Domain/ValueObject/UserIdTest.php

./vendor/bin/phpunit tests/Domain/Entity/UserTest.php

# Para probar con la base de datos mysql
./vendor/bin/phpunit --no-configuration tests/Integration/RegisterUserIntegrationTest.php

# Cobertura
./vendor/bin/phpunit --coverage-html coverage

# Ver cantidad de memoria
php -i | grep memory_limit
