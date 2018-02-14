#!/bin/bash
# Basic until loop

counter=1
until [ $counter -gt 1000 ]   
do
    php yii exchange/generate
    ((counter++))
done

echo All done