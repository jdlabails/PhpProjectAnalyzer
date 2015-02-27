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
rm -f ${DIR_REPORT}/MD/*.txt

echo "Analyse Mess Detector"
echo "${DIR_PHAR}/phpmd.phar ${DIR_SRC} text %%%rule_set%%% --reportfile ${DIR_REPORT}/MD/report.txt" > ${DIR_REPORT}/MD/cmd.txt
echo "${DIR_PHAR}/phpmd.phar ${DIR_SRC} text %%%rule_set%%%" > ${DIR_REPORT}/MD/cmdManuelle.txt

php ${DIR_PHAR}/phpmd.phar ${DIR_SRC} text %%%rule_set%%% --reportfile ${DIR_REPORT}/MD/report.txt

rm -f ${DIR_REPORT}/MD/*.txt

echo "Analyse Mess Detector"
echo "${DIR_PHAR}/phpmd.phar ${DIR_SRC} text codesize,controversial,design,naming,unusedcode --reportfile ${DIR_REPORT}/MD/report.txt" > ${DIR_REPORT}/MD/cmd.txt
echo "${DIR_PHAR}/phpmd.phar ${DIR_SRC} text codesize,controversial,design,naming,unusedcode" > ${DIR_REPORT}/MD/cmdManuelle.txt

php ${DIR_PHAR}/phpmd.phar ${DIR_SRC} text codesize,controversial,design,naming,unusedcode --reportfile ${DIR_REPORT}/MD/report.txt

rm -f ${DIR_JETON}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
