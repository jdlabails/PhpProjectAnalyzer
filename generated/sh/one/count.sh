#!/bin/bash
################################################################################
#
# Script Project Analyser
#
# Date       Auteur       : Contenu
# 2014-09-15 Jean-David Labails   : creation du script
#
################################################################################


#set -e  # fail on first error

#Parametres generaux
DIR_SRC=/home/jd/html/Redis/src  #Repertoire des sources à analyser
DIR_PA=/var/www/html/PhpProjectAnalyzer/assets/php/../../
DIR_REPORT=${DIR_PA}/reports
DIR_PHAR=${DIR_PA}/assets/_phar
DIR_JETON=${DIR_PA}/jetons

#chmod -R 777 ${DIR_REPORT}

touch ${DIR_JETON}/jetonAnalyse

START=`date +%s`

# Reset all variables that might be set
CODE_COVERAGE=0
DOC=0


while getopts cd opt
do
    case $opt in
        c)
            CODE_COVERAGE=1
            ;;
        d)
            DOC=1
            ;;
    esac
done
echo "Comptage"
rm -f ${DIR_REPORT}/COUNT/*.txt
find ${DIR_SRC}/ -type d | wc -l > ${DIR_REPORT}/COUNT/nbDossier.txt
find ${DIR_SRC}/ -type f | wc -l > ${DIR_REPORT}/COUNT/nbFichier.txt
find ${DIR_SRC}/ -type f -name "*.php" | wc -l > ${DIR_REPORT}/COUNT/nbPHP.txt
find ${DIR_SRC}/ -type f -name "*.css" | wc -l > ${DIR_REPORT}/COUNT/nbCSS.txt
find ${DIR_SRC}/ -type f -name "*.js" | wc -l > ${DIR_REPORT}/COUNT/nbJS.txt
find ${DIR_SRC}/ -type f -name "*.min.css" | wc -l > ${DIR_REPORT}/COUNT/nbLibCSS.txt
find ${DIR_SRC}/ -type f -name "*.min.js" | wc -l > ${DIR_REPORT}/COUNT/nbLibJS.txt
find ${DIR_SRC}/ -type f -name "*.twig" | wc -l > ${DIR_REPORT}/COUNT/nbTwig.txt
find ${DIR_SRC}/ -type d -name "*Bundle" | wc -l > ${DIR_REPORT}/COUNT/nbBundle.txt

 
rm -f ${DIR_JETON}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
