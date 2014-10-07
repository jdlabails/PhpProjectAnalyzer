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




### Easy for Symfony2
Made for that ! 
 - Just create a directory 'pa' into your 'web' directory. 
 - Paste the project analyser in this pa directory
 - Edit param.yml to fit your project
 - call pa/index.php with your nav.
 - click on 'Lancer l'analyse'

### Todo
This project is a pure PHP code et bash scripts.
It could be refactoring and a bundle for Symfony should be made.

The following asset are missing

Atoum testing
