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

rm -f ${DIR_REPORT}/TEST/cmd.txt ${DIR_REPORT}/TEST/report.txt ${DIR_REPORT}/TEST/cmdManuelle.txt
    
echo "cd ${DIR_SRC}/../" > ${DIR_REPORT}/TEST/cmd.txt
echo "/home/jd/html/Redis/vendor/bin/atoum -d /home/jd/html/Redis/tests " > ${DIR_REPORT}/TEST/cmdManuelle.txt
    
if [ ${CODE_COVERAGE} -eq 1 ]
then
    echo "Lancement des tests unitaires atoum AVEC code-coverage"
    echo "/home/jd/html/Redis/vendor/bin/atoum -d /home/jd/html/Redis/tests -c ${DIR_PA}assets/php/atoum.cc.php" >> ${DIR_REPORT}/TEST/cmd.txt
    
    cd ${DIR_SRC}/../

    /home/jd/html/Redis/vendor/bin/atoum -d /home/jd/html/Redis/tests -c ${DIR_PA}assets/php/atoum.cc.php > ${DIR_REPORT}/TEST/report.txt 2>&1
else
    echo "Lancement des tests unitaires atoum SANS code-coverage"
    echo "/home/jd/html/Redis/vendor/bin/atoum -d /home/jd/html/Redis/tests" >> ${DIR_REPORT}/TEST/cmd.txt
    
    cd ${DIR_SRC}/../
    /home/jd/html/Redis/vendor/bin/atoum -d /home/jd/html/Redis/tests > ${DIR_REPORT}/TEST/report.txt 2>&1
fi

rm -f ${DIR_JETON}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
