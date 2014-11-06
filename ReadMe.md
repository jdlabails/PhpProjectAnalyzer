### What is it ?
These script are simple automating script to analyse a php project and give
a constructed view of the results.


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
 - Click on 'Start Scan'

### Road Map

 - DataBase following of the project
 - Atoum support
 - Remote version to analyse several projects
