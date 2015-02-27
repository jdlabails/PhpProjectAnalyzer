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

 
rm -f ${DIR_REPORT}/CPD/*.txt

echo "Analyse Copy-Paste"
echo "php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC}" > ${DIR_REPORT}/CPD/cmd.txt 
echo "php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC}" > ${DIR_REPORT}/CPD/cmdManuelle.txt

php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC} > ${DIR_REPORT}/CPD/report.txt 2>&1

rm -f ${DIR_REPORT}/CS/*.txt

echo "Analyse code sniffer"
echo "php ${DIR_PHAR}/phpcs.phar --report-file=${DIR_REPORT}/CS/report.txt --extensions=php --standard=PSR2 ${DIR_SRC}" > ${DIR_REPORT}/CS/cmd.txt
echo "php ${DIR_PHAR}/phpcs.phar --extensions=php --standard=PSR2 ${DIR_SRC}" > ${DIR_REPORT}/CS/cmdManuelle.txt
echo "php ${DIR_PHAR}/phpcbf.phar --extensions=php --standard=PSR2 --no-patch ${DIR_SRC}" > ${DIR_REPORT}/CS/cmdRep.txt

php ${DIR_PHAR}/phpcs.phar --report-file=${DIR_REPORT}/CS/report.txt --extensions=php --standard=PSR2 ${DIR_SRC} > ${DIR_REPORT}/CS/summary.txt 2>&1

rm -f ${DIR_REPORT}/DEPEND/*.txt

echo "Calcul de metriques par PhpDepend"
echo "php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC}"  > ${DIR_REPORT}/DEPEND/cmd.txt
echo "php ${DIR_PHAR}/pdepend.phar ${DIR_SRC}"  > ${DIR_REPORT}/DEPEND/cmdManuelle.txt

php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC} > ${DIR_REPORT}/DEPEND/report.txt 2>&1

rm -f ${DIR_REPORT}/LOC/*.txt

echo "Mesures des sources par PhpLoc"
echo "php ${DIR_PHAR}/phploc.phar --log-xml ${DIR_REPORT}/LOC/phploc.xml ${DIR_SRC}" > ${DIR_REPORT}/LOC/cmd.txt
echo "php ${DIR_PHAR}/phploc.phar ${DIR_SRC}" > ${DIR_REPORT}/LOC/cmdManuelle.txt

php ${DIR_PHAR}/phploc.phar --log-xml ${DIR_REPORT}/LOC/phploc.xml ${DIR_SRC} > ${DIR_REPORT}/LOC/report.txt 2>&1

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

if [ ${DOC} -eq 1 ]
then
    rm -rf ${DIR_REPORT}/DOCS/*
    echo "Rédaction de la documentation"
    echo "php ${DIR_PHAR}/phpDocumentor.phar -d ${DIR_SRC} -t ${DIR_REPORT}/DOCS" > ${DIR_REPORT}/DOCS/cmd.txt
    php ${DIR_PHAR}/phpDocumentor.phar -d ${DIR_SRC} -t ${DIR_REPORT}/DOCS > ${DIR_REPORT}/DOCS/report.txt 2>&1
fi


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
