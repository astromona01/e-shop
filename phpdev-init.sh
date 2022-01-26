						Exercise 6

1)  написать shell-скрипт, который помогает установить все программное обеспечение из лекции №2 вызовом одной команды в консоли:
	sudo apt install php-fpm phpmyadmin mysqlserver oh-my-zsh

2) чуть сложнее - с помощью скрипта скачать и установить visual studio code, для скачивания wget или curl для установки dpkg
	sudo apt install software-properties-common apt-transport-https wget
	wget -q https://packages.microsoft.com/keys/microsoft.asc -O- | sudo apt-key add -
	sudo add-apt-repository "deb [arch=amd64] https://packages.microsoft.com/repos/vscode stable main"
	sudo apt install code
