import pythonHelp.csv_to_array as csvArray
import numpy as np
import matplotlib
import matplotlib.pyplot as plt

if __name__ == '__main__':
  dataset = csvArray.csv_to_array('dataset_train.csv')
  data = dataset[1:, :]
  data = data[data[:, 1].argsort()]

  X = np.array(data[:, 16], dtype=float)
  legend = ['Grynffindor', 'Hufflepuff', 'Ravenclaw', 'Slytherin']

  h1 = X[:327]
  h1 = h1[~np.isnan(h1)]
  plt.hist(h1, color='red', alpha=0.5)

  h2 = X[327:856]
  h2 = h2[~np.isnan(h2)]
  plt.hist(h2, color='yellow', alpha=0.5)

  h3 = X[856:1299]
  h3 = h3[~np.isnan(h3)]
  plt.hist(h3, color='blue', alpha=0.5)

  h4 = X[1299:]
  h4 = h4[~np.isnan(h4)]
  plt.hist(h4, color='green', alpha=0.5)

  plt.legend(legend, loc='upper right', frameon=False)
  plt.title(dataset[0, 16])
  plt.xlabel('Notes')
  plt.ylabel('Nombre d\'étudiants')
  plt.show()