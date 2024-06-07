# MasterMindSymfony

Start php project, without symfony:  
$cd MasterMind  
$php -S localhost:8080  
in browser (defaut launch index.php)  
http://localhost:8080/master.php  

Create symfony new project:  
$symfony new my_project  

Before controller by command,  
install bundle maker:  
$symfony composer req maker --dev  
install annotations php:  
$symfony composer req annotations  

Create controller:  
$symfony console make:controller NameController  

Start symfony project:  
$cd my-project/  
$symfony server:start  
  [OK] Web server listening on http://127.0.0.1:....  
  ...  
$symfony open:local  

Start dump:  
$php bin/console server:dump


Check project size:  
$du -sh .  

composer require "twig/twig:^2.0"  
composer require twig  

composer require --dev symfony/var-dumper  
