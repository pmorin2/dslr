# dslr

## Project setup
```
pip3 install numpy
pip3 install pandas
pip3 install sklearn
pip3 install matplotlib
```

## Scripts usage
``` 
-php describe.php dataset_test.csv ([fr]conseil: pour avoir un affichage propre, augmenter la largeur de votre terminal et si necessaire, dézoomez (CTRL+MINUS)[fr])
-python3 histogram.py
-python3 scatter_plot.py
-pair_plot.py
-python3 logreg_train.py dataset_train.py | python3 logreg_predict.py dataset_test.csv weights.csv
```

## Bonus usage
```
-php -S 127.0.0.1:8000 | go to localhost:8000/histogram.php?csv=dataset_train.csv
```