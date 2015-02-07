
echo "Réparation code sniffer"
rm -f ${DIR_REPORT}/CS/*.txt
echo "php ${DIR_PHAR}/phpcbf.phar --extensions=php --standard=%%%standard%%% ${DIR_SRC} --no-patch" > ${DIR_REPORT}/CS/cmd.txt
php ${DIR_PHAR}/phpcbf.phar --extensions=php --standard=%%%standard%%% ${DIR_SRC} --no-patch > ${DIR_REPORT}/CS/summary.txt 2>&1
