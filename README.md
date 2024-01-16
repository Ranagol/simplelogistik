# Developer's 
### Setting up the development Environment


<div style="color: #991228">
<strong>
Windows Users may experience some issues with file permissions. Therefore it's highly recommended to store the files in the WSL2 Distro File-System.
</strong>
</div>
<br />

```bash
# (optional) create shortcut for sail command
echo 'alias sail="./vendor/bin/sail"' >> ~/.bashrc
source ~/.bashrc

# when using Github CLI
gh repo clone Ranagol/simplelogistik <target-folder>

# when using regular git commands (HTTPS)
git clone https://github.com/Ranagol/simplelogistik.git <target-folder>

# when using regular git commands (SSH)
git clone git@github.com:Ranagol/simplelogistik.git <target-folder>

cd <target-folder>

# copy .env file. (update before starting Docker container)
cp .env.example .env

# Run Docker in detached mode (background)
sail up -d

# install composer dependencies
sail composer install

# install node packages
sail yarn

# run vite development bridge
sail yarn dev

# Generate App Key
sail artisan key:generate

# Run migrations 
sail artisan migrate

# (development only!!) to populate system with fake data. Before seeding create test user (see next chapter for more info)
sail artisan db:seed
```

### The test user
You must create a test user, in order to be able to log in and use the app. This test user defining
is happening in the .env. Just specify your email and your password like in this example:
TEST_USERNAME=user@gmail.com
TEST_PASSWORD=12345
After you defined your test user credentials, then you can seed the db.