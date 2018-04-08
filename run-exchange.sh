#!/bin/bash
# Basic until loop

counter=1
until [ $counter -gt 90 ]
do
    php yii exchange/run > /dev/null
    ((counter++))
done

echo All done