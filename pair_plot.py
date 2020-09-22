import pythonHelp.csv_to_array as csvArray
import numpy as np
import matplotlib
import matplotlib.pyplot as plt

if __name__ == '__main__':
  dataset = csvArray.csv_to_array('dataset_train.csv')
  data = dataset[1:, 6:]
  data = data[data[:, 1].argsort()]

  features = dataset[0, 6:]
  legend = ['Grynffindor', 'Hufflepuff', 'Ravenclaw', 'Slytherin']
  data = np.array(data, dtype=float)
  font = {'family' : 'Lucida Grande',
          'weight' : 'light',
          'size'   : 7}
  matplotlib.rc('font', **font)

  size = data.shape[1]
  _, ax = plt.subplots(nrows=size, ncols=size)
  plt.subplots_adjust(wspace=0.2, hspace=0.2, left=0.07, top=0.95, right=0.915)

  for row in range(0, size):
    for col in range(0, size):
      X = data[:, col]
      y = data[:, row]

      if col == row:                                ## Histogram ##
        h1 = X[:327]
        h1 = h1[~np.isnan(h1)]
        ax[row, col].hist(h1, alpha=0.5)

        h2 = X[327:856]
        h2 = h2[~np.isnan(h2)]
        ax[row, col].hist(h2, alpha=0.5)

        h3 = X[856:1299]
        h3 = h3[~np.isnan(h3)]
        ax[row, col].hist(h3, alpha=0.5)

        h4 = X[1299:]
        h4 = h4[~np.isnan(h4)]
        ax[row, col].hist(h4, alpha=0.5)
      else:                                     ## Scatter_plot ##
        ax[row, col].scatter(X[:327], y[:327], s=1, color='red', alpha=0.5)
        ax[row, col].scatter(X[327:856], y[327:856], s=1, color='yellow', alpha=0.5)
        ax[row, col].scatter(X[856:1299], y[856:1299], s=1, color='blue', alpha=0.5)
        ax[row, col].scatter(X[1299:], y[1299:], s=1, color='green', alpha=0.5)

      if ax[row, col].is_last_row():
        ax[row, col].set_xlabel(features[col].replace(' ', '\n'))
        ax[row, col].tick_params(labelsize=4.5)
      else:
        ax[row, col].tick_params(labelbottom=False, bottom=False)

      if ax[row, col].is_first_col():
        ax[row, col].set_ylabel(features[row].replace(' ', '\n'))
        ax[row, col].tick_params(labelsize=4.5)
      else:
        ax[row, col].tick_params(labelleft=False, left=False)

#       ax[row, col].spines['right'].set_visible(False)
#       ax[row, col].spines['top'].set_visible(False)

  plt.legend(legend, loc='center left', frameon=False, bbox_to_anchor=(1, 0.5))
  plt.show()