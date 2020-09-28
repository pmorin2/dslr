from sklearn.metrics import accuracy_score
import argparse
import pandas

if __name__ == '__main__':
  parser = argparse.ArgumentParser()
  parser.add_argument("dataset_house", type=str, help="input dataset")
  parser.add_argument("dataset_truth", type=str, help="input weights")
  args = parser.parse_args()

  predict = pandas.read_csv(args.dataset_house).values[:, 1]
  real = pandas.read_csv(args.dataset_truth).values[:, 1]

print(f'Accuracy: {accuracy_score(predict, real):.2f}')