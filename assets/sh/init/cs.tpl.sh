
echo "Analyse code sniffer"
rm -f ${DIR_REPORT}/CS/*.txt
echo "php ${DIR_PHAR}/phpcs.phar --report-file=${DIR_REPORT}/CS/report.txt --extensions=php --standard=%%%standard%%% ${DIR_SRC}" > ${DIR_REPORT}/CS/cmd.txt
php ${DIR_PHAR}/phpcs.phar --report-file=${DIR_REPORT}/CS/report.txt --extensions=php --standard=%%%standard%%% ${DIR_SRC} > ${DIR_REPORT}/CS/summary.txt 2>&1

