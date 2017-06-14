import math


class Heuristic:
    # sigmoid function
    def sigmoid(self, x):
        return 1 / (1 + math.exp(-x))
