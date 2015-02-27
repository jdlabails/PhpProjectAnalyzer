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
rm -f ${DIR_REPORT}/DEPEND/*.txt

echo "Calcul de metriques par PhpDepend"
echo "php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC}"  > ${DIR_REPORT}/DEPEND/cmd.txt
echo "php ${DIR_PHAR}/pdepend.phar ${DIR_SRC}"  > ${DIR_REPORT}/DEPEND/cmdManuelle.txt

php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC} > ${DIR_REPORT}/DEPEND/report.txt 2>&1

rm -f ${DIR_JETON}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
