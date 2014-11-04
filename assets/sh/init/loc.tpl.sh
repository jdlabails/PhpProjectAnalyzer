
echo "Mesures des sources par PhpLoc"
rm -f ${DIR_REPORT}/LOC/*.txt
echo "php ${DIR_PHAR}/phploc.phar --log-xml ${DIR_REPORT}/LOC/phploc.xml ${DIR_SRC}" > ${DIR_REPORT}/LOC/cmd.txt
php ${DIR_PHAR}/phploc.phar --log-xml ${DIR_REPORT}/LOC/phploc.xml ${DIR_SRC} > ${DIR_REPORT}/LOC/report.txt 2>&1
