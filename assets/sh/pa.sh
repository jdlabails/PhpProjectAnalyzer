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
DIR_SRC=/home/FIDUCIAL/adm_jd.labails/fos/src  #Repertoire des sources à analyser
DIR_PA=/home/FIDUCIAL/adm_jd.labails/fos/web/pa
DIR_REPORT=${DIR_PA}/reports
DIR_PHAR=${DIR_PA}/assets/_phar

chmod -R 777 ${DIR_REPORT}

touch ${DIR_PA}/jetonAnalyse

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

echo "Analyse code sniffer"
rm -f ${DIR_REPORT}/CS/*.txt
php ${DIR_PHAR}/phpcs.phar --report-file=${DIR_REPORT}/CS/report.txt --extensions=php --standard=PSR2 ${DIR_SRC} > ${DIR_REPORT}/CS/summary.txt 2>&1

echo "Analyse Mess Detector"
rm -f ${DIR_REPORT}/MD/report.txt
php ${DIR_PHAR}/phpmd.phar ${DIR_SRC} text codesize,controversial,design,naming,unusedcode --reportfile ${DIR_REPORT}/MD/report.txt

echo "Calcul de metriques par PhpDepend"
rm -f ${DIR_REPORT}/DEPEND/report.txt
php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC} > ${DIR_REPORT}/DEPEND/report.txt 2>&1

echo "Analyse Copy-Paste"
rm -f ${DIR_REPORT}/CPD/report.txt
php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC} > ${DIR_REPORT}/CPD/report.txt 2>&1

echo "Mesures des sources par PhpLoc"
rm -f ${DIR_REPORT}/LOC/report.txt
php ${DIR_PHAR}/phploc.phar --log-xml ${DIR_REPORT}/LOC/phploc.xml ${DIR_SRC} > ${DIR_REPORT}/LOC/report.txt 2>&1


if [ ${CODE_COVERAGE} -eq 1 ]
then
    echo "Lancement des tests unitaires AVEC code-coverage"
    rm -f ${DIR_REPORT}/TEST/report.txt
    cd ${DIR_SRC}/../
    php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=GesMouv --coverage-text=${DIR_REPORT}/TEST/coverage.txt --coverage-html ${DIR_REPORT}/TEST/phpUnitReport/ ${DIR_SRC} > ${DIR_REPORT}/TEST/report.txt 2>&1
else
    echo "Lancement des tests unitaires SANS code-coverage"
    rm -f ${DIR_REPORT}/TEST/report.txt
    cd ${DIR_SRC}/../
    php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=GesMouv ${DIR_SRC} > ${DIR_REPORT}/TEST/report.txt 2>&1
fi


if [ ${DOC} -eq 1 ]
then
    echo "Rédaction de la documentation"
    rm -f ${DIR_REPORT}/DOCS/report.txt
    php ${DIR_PHAR}/phpDocumentor.phar -d ${DIR_SRC} -t ${DIR_REPORT}/DOCS > ${DIR_REPORT}/DOCS/report.txt 2>&1
fi

rm -f ${DIR_PA}/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_PA}/timeAnalyse


exit 0;
