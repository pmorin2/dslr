import numpy as np

def train_test_split(X, y, test_size=0.3, random_state=None):
  if random_state:
    np.random.seed(random_state)

  p = np.random.permutation(len(X))

  X_offset = int(len(X) * test_size)
  y_offset = int(len(y) * test_size)

  X_train = X[p][X_offset:]
  X_test = X[p][:X_offset]

  y_train = y[p][y_offset:]
  y_test = y[p][:y_offset]
  return (X_train, X_test, y_train, y_test)

class StandardScaler(object):
  def __init__(self, mean=np.array([]), std=np.array([])):
    self._mean = mean
    self._std = std

  def fit(self, X):
    for i in range(0, X.shape[1]):
      self._mean = np.append(self._mean, self.ft_mean(X[:, i]))
      self._std = np.append(self._std, self.ft_std(X[:, i]))

  def transform(self, X):
    return ((X - self._mean) / self._std)

  def ft_mean(self, X):
    total = 0
    for x in X:
      if np.isnan(x):
        continue
      total = total + x
    return total / len(X)

  def ft_std(self, X):
    mean = self.ft_mean(X)
    total = 0
    for x in X:
      if np.isnan(x):
        continue
      total = total + (x - mean) ** 2
    return (total / len(X)) ** 0.5