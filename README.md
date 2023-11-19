Starting the app with Laravel server:

Set your .env file, connect your app to a database.
Open a terminal, run 'php artisan serve'.
Open another terminal, run 'npm run dev'.
Go to: http://127.0.0.1:8000/

Starting the app with Docker:
http://localhost/   (app will be here)
sail artisan up     (this will run docker and the backend)
sail npm run dev    (this will run frontend)
sail artisan down   (turn of Docker)


Seeding the database with fake data:
In Docker:      sail artisan db:seed 
In Laravel:     php artisan db:seed 