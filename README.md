Starting the app with Laravel server:

Set your .env file, connect your app to a database.
Open a terminal, run 'php artisan serve'.
Open another terminal, run 'npm run dev'.
Go to: http://127.0.0.1:8000/

Starting the app with Docker:
docker-compose up
npm run dev
Go to: http://localhost/


Seeding the database with fake data:
Docker: sail artisan db:seed 
Laravel: php artisan db:seed 