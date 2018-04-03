#!/bin/bash
# Basic until loop

counter=1
until [ $counter -gt 5 ]
do
    php yii exchange/run
    ((counter++))
done

echo All done