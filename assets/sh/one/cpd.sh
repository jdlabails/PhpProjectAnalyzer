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
DIR_SRC=/home/jd/www/AtelierSF2/starterkit_sf2/src  #Repertoire des sources à analyser
DIR_PA=/home/jd/www/AtelierSF2/starterkit_sf2/web/PhpProjectAnalyzer
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
rm -f ${DIR_REPORT}/CPD/*.txt

echo "Analyse Copy-Paste"
echo "php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC}" > ${DIR_REPORT}/CPD/cmd.txt 
echo "php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC}" > ${DIR_REPORT}/CPD/cmdManuelle.txt

php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC} > ${DIR_REPORT}/CPD/report.txt 2>&1

rm -f ${DIR_JETON}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
