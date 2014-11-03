
echo "Analyse Copy-Paste"
rm -f ${DIR_REPORT}/CPD/*.txt
echo "php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC}" > ${DIR_REPORT}/CPD/cmd.txt
php ${DIR_PHAR}/phpcpd.phar ${DIR_SRC} > ${DIR_REPORT}/CPD/report.txt 2>&1

