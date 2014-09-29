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

![](https://github.com/jdlabails/PhpProjectAnalyser/ppaIndex.png)

```
$ cd your_repo_root/repo_name
$ git fetch origin
$ git checkout gh-pages
```


### Easy for Symfony2
Made for that ! Just create a directory 'pa' into your web directory. Put the project analyser in it and call pa/index.php with your nav.

### Todo
This project is a pure PHP code et bash scripts.
It could be refactoring and a bundle for Symfony should be made.

The following asset are missing

Atoum testing
Fine configuration