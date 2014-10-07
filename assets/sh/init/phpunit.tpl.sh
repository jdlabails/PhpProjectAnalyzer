
if [ ${CODE_COVERAGE} -eq 1 ]
then
    echo "Lancement des tests unitaires AVEC code-coverage"
    rm -f ${DIR_REPORT}/TEST/*.txt
    echo "cd ${DIR_SRC}/../" > ${DIR_REPORT}/TEST/cmd.txt
    echo "php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=%%%testsuite%%% --coverage-text=${DIR_REPORT}/TEST/coverage.txt --coverage-html ${DIR_REPORT}/TEST/phpUnitReport/ ${DIR_SRC}" >> ${DIR_REPORT}/TEST/cmd.txt
    cd ${DIR_SRC}/../
    php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=%%%testsuite%%% --coverage-text=${DIR_REPORT}/TEST/coverage.txt --coverage-html ${DIR_REPORT}/TEST/phpUnitReport/ ${DIR_SRC} > ${DIR_REPORT}/TEST/report.txt 2>&1
else
    echo "Lancement des tests unitaires SANS code-coverage"
    rm -f ${DIR_REPORT}/TEST/*.txt
    echo "cd ${DIR_SRC}/../" > ${DIR_REPORT}/TEST/cmd.txt
    echo "php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=%%%testsuite%%% ${DIR_SRC}" >> ${DIR_REPORT}/TEST/cmd.txt
    cd ${DIR_SRC}/../
    php ${DIR_PHAR}/phpunit.phar -c ${DIR_SRC}/../app/phpunit.xml.dist --testsuite=%%%testsuite%%% ${DIR_SRC} > ${DIR_REPORT}/TEST/report.txt 2>&1
fi
