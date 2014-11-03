
rm -f ${DIR_PA}/jetons/jetonAnalyse

END=`date +%s`

echo $((END-START)) > ${DIR_JETON}/timeAnalyse


exit 0;
