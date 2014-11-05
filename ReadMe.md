### What is it ?
These script are simple automating script to analyse a php project and give
a constructed view of the results.

Take care, it's all in French.


It executes
 - PHPMD
 - PHPUnit
 - PHPCS
 - Copy paste detector
 - Php Depend
 - Php loc
 - PhpDoc

And give a view like :

![](https://raw.githubusercontent.com/jdlabails/PhpProjectAnalyzer/master/ppaIndex.png)




### Easy for Symfony2  - Made for that !
 - Go to your web directory
 - Launch git clone https://github.com/jdlabails/PhpProjectAnalyzer.git
 - As root, launch web/PhpProjectAnalyzer/assets/sh/install.sh
 - Move assets/param.dist.yml to assets/param.yml
 - Edit assets/param.yml to fit your project
 - Call yoursymfonyproject/PhpProjectAnalyzer/index.php with your nav.
 - Click on 'Lancer l'analyse'

### Todo
This project is a pure PHP code et bash scripts.
It could be refactoring and a bundle for Symfony should be made.

The following asset are missing

Atoum testing

### Road Map

 - English version
 - Better code structuration
 - DataBase following of the project
 - Atoum support
