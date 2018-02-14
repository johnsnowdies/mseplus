FOR /L %%A IN (1,1,200) DO (
  ECHO %%A
  docker exec -ti funds_app_1 php yii exchange/run
)