Para executar o sistema siga os passos a seguir:

1 - Execute o comando:
composer install

2 - Inclua esse arquivo .env na raiz do projeto
APP_KEY=base64:WjExfYSMxQk2illn8XyTaNtvx/Prwighb+UCvFoP55M=

DB_CONNECTION=pgsql
DB_HOST=aws-0-sa-east-1.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.xeldksiqsxzpxqigmhua
DB_PASSWORD=jm9HpAWnJGJNk4fZ

3 - Execute o comando:
php artisan key:generate

4 - Rode o projeto
php artisan serve