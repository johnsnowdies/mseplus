#!/bin/bash
# Basic until loop

counter=1
until [ $counter -gt 100 ]
do
    php yii exchange/run
    ((counter++))
done

echo All done