# portal

## Installation using Vagrant

### 1) You need installed on your local machine: Vagrant, Ansible, Virtualbox, Composer

### 2) Fork https://github.com/czvl/portal

### 3) Clone your fork
```code
git clone ...
```
```code
cd portal
vagrant up
```
### 4) Install dependencies
```code
cd app
composer up
```
### Go to guest (started on Virtualbox) machine:
```code
vagrant ssh
cd /vagrant/protected/yiic migrate
protected/yiic migrate
```
### Add payment config file:
app/protected/config/payment_local.php
```php
<?php
return [
    'liqpay' => [
        'public_key' => '12345',
        'private_key' => 'qwerty',
    ]
];
```
### Create admin 
```mysql
INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `role`, `signin_time`, `last_login`, `status`, `phone`, `position`, `additional_contact`, `hash`, `email_confirmed`) VALUES
(1, 'test', 'hZVCu4ED5zRsY', 'email@gmail.com', 'FirstName', 'LastName', 'administrator', '2015-06-25 16:38:49', '2015-11-08 00:01:15', 1, NULL, NULL, NULL, NULL, NULL)
```
It will allow you enter with
login:test
password:12345
