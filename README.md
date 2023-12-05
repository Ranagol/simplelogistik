# Start the app
## Starting the app with Laravel server:

Set your .env file, connect your app to a database.   
Open a terminal, run 'php artisan serve'.   
Open another terminal, run 'npm run dev'.   
Go to: http://127.0.0.1:8000/  

## Starting the app with Docker:
after cloning the files from repository:
composer update && npm install
cp .env.example .env
./vendor/bin/sail up -d           (this will run docker and the backend)  
php artisan migrate               (this will setup/update all tables )          !! have to be automated !!
php artisan db:seed               (Seeding the database with fake data)
npm install --save-dev @vitejs/plugin-vue
./vendor/bin/sail npm run dev
http://localhost/                 (app will be here)  


# sail npm run dev    (this will run frontend)  
# sail artisan down   (turn of Docker) 


# Seeding the database with fake data:
# In Docker:      ./vendor/bin/sail artisan db:seed  
# In Laravel:     php artisan db:seed   -->