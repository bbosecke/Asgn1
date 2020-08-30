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

  #naming of the server
  config.vm.define "webserver" do |webserver|
    webserver.vm.hostname = "webserver"

    #port forwarding enabled
    webserver.vm.network "forwarded_port", guest:80, host:8080, host_ip: "127.0.0.1"

    #to access the website from the internet, http://192.169.2.11
    webserver.vm.network "private_network", ip: "192.168.2.11"
    
    webserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    #Provisionning occurs when the machine is vagrant 'upped', and the installations required will be installed during start-up
    webserver.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

      cp /vagrant/index.conf /etc/apache2/sites-available/
      a2ensite index
      a2dissite 000-default
      service apache2 reload

   SHELL
    
    
  end

  #Naming Admin Server
  config.vm.define "adminserver" do |adminserver|
    adminserver.vm.hostname = "adminserver"

    #port forwarding enabled - using port 8081 because webserver uses 8080
    adminserver.vm.network "forwarded_port", guest:80, host:8081, host_ip: "127.0.0.1"

    #access the website through the internet, http://192.168.2.13/admin.php
    adminserver.vm.network "private_network", ip: "192.168.2.13"
    
    adminserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    #Provisionning occurs when the machine is vagrant 'upped', and the installations required will be installed during start-up
    adminserver.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

      cp /vagrant/admin.conf /etc/apache2/sites-available/
      a2ensite admin
      a2dissite 000-default
      service apache2 reload

   SHELL
    
    
  end

  #Naming of the dbserver
  config.vm.define "dbserver" do |dbserver|
    dbserver.vm.hostname = "dbserver"

    #different IP address to the webserver and adminserver
    dbserver.vm.network "private_network", ip: "192.168.2.12"
    dbserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    #Provisionning occurs when the machine is vagrant 'upped', and the installations required will be installed during start-up
    dbserver.vm.provision "shell", inline: <<-SHELL

    sudo apt-get update
    export MYSQL_PWD='insecure_mysqlroot_pw'
    echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
    echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections
    apt-get -y install mysql-server
    echo "CREATE DATABASE contestants;" | mysql
    echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'insecure_db_pw';" | mysql
    echo "GRANT ALL PRIVILEGES ON contestants.* TO 'webuser'@'%'" | mysql

    export MYSQL_PWD='insecure_db_pw'
    #creates the table from setup-database.sql
    cat /vagrant/setup-database.sql | mysql -u webuser contestants

    # so the webserver can connect to the database server:
    sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

    service mysql restart
    SHELL
  end 


end
