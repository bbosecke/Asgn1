# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "ubuntu/xenial64"
  
  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  #name of the server
  config.vm.define "webserver" do |webserver|
    webserver.vm.hostname = "webserver"

    #port forwarding enabled
    webserver.vm.network "forwarded_port", guest:80, host:8080, host_ip: "127.0.0.1"


    webserver.vm.network "private_network", ip: "192.168.2.11"
    
    webserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    webserver.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

    export MYSQL_PWD='insecure_mysqlroot_pw'
    echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
    echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections
    apt-get -y install mysql-server
    echo "CREATE DATABASE contestants;" | mysql
    echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'insecure_db_pw';" | mysql
    echo "GRANT ALL PRIVILEGES ON contestants.* TO 'webuser'@'%'" | mysql

    export MYSQL_PWD='insecure_db_pw'
    cat /vagrant/setup-database.sql | mysql -u webuser contestants

    service mysql restart
     echo "WELCOME TO WEBSERVER"
    SHELL

    
    
  end

end
