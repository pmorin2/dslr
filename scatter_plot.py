import pythonHelp.csv_to_array as csvArray
import numpy as np
import matplotlib
import matplotlib.pyplot as plt

if __name__ == '__main__':
  dataset = csvArray.csv_to_array('dataset_train.csv')
  data = dataset[1:, :]
  data = data[data[:, 1].argsort()]

  X = np.array(data[:, 7], dtype=float)
  y = np.array(data[:, 9], dtype=float)
  legend = ['Grynffindor', 'Hufflepuff', 'Ravenclaw', 'Slytherin']

  plt.scatter(X[:327], y[:327], color='red', alpha=0.5)
  plt.scatter(X[327:856], y[327:856], color='yellow', alpha=0.5)
  plt.scatter(X[856:1299], y[856:1299], color='blue', alpha=0.5)
  plt.scatter(X[1299:], y[1299:], color='green', alpha=0.5)

  plt.legend(legend, loc='upper right', frameon=False)
  plt.xlabel(dataset[0, 7])
  plt.ylabel(dataset[0, 9])
  plt.show()