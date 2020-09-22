from pythonHelp.preprocessing import StandardScaler, train_test_split
from pythonHelp.model import LogisticRegression

from sklearn.metrics import accuracy_score

import argparse
import pandas


import matplotlib.pyplot as plt
import numpy as np

if __name__ == '__main__':
  parser = argparse.ArgumentParser()
  parser.add_argument("dataset", type=str, help="input dataset")
  parser.add_argument('-g', '--graph', action="store_true", help="Show model")
  args = parser.parse_args()

  df = pandas.read_csv(args.dataset)
  df = df.dropna(subset=['Defense Against the Dark Arts'])
  df = df.dropna(subset=['Charms'])
  df = df.dropna(subset=['Herbology'])
  df = df.dropna(subset=['Divination'])
  df = df.dropna(subset=['Muggle Studies'])
  df = df.dropna(subset=['Flying'])
  X = np.array(df.values[:, [9, 17, 8, 10, 11, 18]], dtype=float)
  y = df.values[:, 1]

  X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=4)

  sc = StandardScaler()
  sc.fit(X_train)

  X_train_std = sc.transform(X_train)
  X_test_std = sc.transform(X_test)

  lr = LogisticRegression(eta=0.01, max_iter=1000, Lambda=10)
  lr.big_formula(X_train_std, y_train)

  if (args.graph):
    _, ax = plt.subplots(nrows=1, ncols=2, figsize=(16, 8), constrained_layout=True)

    ax[0].plot(range(1, len(lr._cost) + 1), lr._cost, marker='o')
    ax[0].set_xlabel('Epochs')
    ax[0].set_ylabel('Cost function')
    ax[0].set_title('Logistic Regression Cost | training rate=0.1')

    ax[1].plot(range(1, len(lr._errors) + 1), lr._errors, marker='o')
    ax[1].set_xlabel('Epochs')
    ax[1].set_ylabel('Misclassification')
    ax[1].set_title('Logistic Regression Error | training rate=0.1')
    plt.show()

  y_pred = lr.predict(X_test_std)
  print(f'Misclasified samples: {sum(y_test != y_pred)}')
  print(f'Accuracy: {accuracy_score(y_test, y_pred):.2f}')

  lr.save_model(sc)
