#/bin/bash

#sudo apt update && sudo apt upgrade -y

echo "Installing base utilities"
sudo apt install -y gcc make perl git curl htop mc zsh vim 

echo "Installing guest additions. Media must be mounted!"
sudo sh /media/user/VBox_GAs_6.1.30/autorun.sh
sudo adduser user vboxsf

echo "Installing web stack"
sudo apt install nginx mysql-server php-fpm php-intl php-mysql
sudo mysql -uroot -e "UPDATE mysql.user SET plugin = 'mysql_native_password', authentication_string  = '' WHERE user = 'root';"
sudo service mysql restart

echo "Installing PMA"
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $APP_PASS" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $ROOT_PASS" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $APP_DB_PASS" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect" | sudo debconf-set-selections

sudo apt install -y phpmyadmin

sudo ln -s /www/phpdev-01/conf/pma.conf /etc/nginx/sites-enabled/pma

echo "\n\n###" | sudo tee -a /etc/hosts
echo "127.0.0.1\tpma.my" | sudo tee -a /etc/hosts


# Git config
echo "Git config"
git config --global user.email "maksim.i.borisov@gmail.com"
git config --global user.name "Maksim Borisov"

echo "Adding dev01.my host to nginx & hosts"
sudo ln -s /www/phpdev-01/conf/local.nginx /etc/nginx/sites-enabled/phpdev
echo "127.0.0.1\tdev01.my" | sudo tee -a /etc/hosts

echo "Installing MS VS Code"
sudo snap install code --classic

echo "Installing smartGIT"
cd ~ && wget https://www.syntevo.com/downloads/smartgit/smartgit-linux-21_2_2.tar.gz
tar -xzf smartgit-linux-21_2_2.tar.gz
sudo mv smartgit /opt/
sudo sh /opt/smartgit/bin/add-menuitem.sh

cd ~
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i --force-depends google-chrome-stable_current_amd64.deb
sudo apt remove firefox

sh -c "$(curl -fsSL https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

ssh-keygen -t rsa -q -f "$HOME/.ssh/id_rsa" -N ""
