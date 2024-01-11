# Developer's 
### Setting up the development Environment


<div style="color: #991228">
<strong>
Windows Users may experience some issues with file permissions. Therefore it's highly recommendet to store the files in the WSL2 Distro File-System.
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

# (development only!!) to populate system with fake data
sail artisan db:seed
```
