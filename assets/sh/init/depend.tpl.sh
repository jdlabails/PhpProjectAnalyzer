
echo "Calcul de metriques par PhpDepend"
rm -f ${DIR_REPORT}/DEPEND/*.txt
echo "php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC}"  > ${DIR_REPORT}/DEPEND/cmd.txt
php ${DIR_PHAR}/pdepend.phar --summary-xml=${DIR_REPORT}/DEPEND/summary.xml --jdepend-chart=${DIR_REPORT}/DEPEND/jdepend.svg --overview-pyramid=${DIR_REPORT}/DEPEND/pyramid.svg ${DIR_SRC} > ${DIR_REPORT}/DEPEND/report.txt 2>&1
