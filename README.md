1) $ composer install
2) DATABASE_URL="mysql://root:root@127.0.0.1:3306/database_name" - настройкалоо, озунун userini password кой
3) 2 stepте жазылган database базада жок болсо: $ php bin/console doctrine:database:create
4) $ php bin/console make:migration
5) $ php bin/console doctrine:migrations:migrate
6) $ symfony server:start