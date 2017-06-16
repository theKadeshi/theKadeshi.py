import math


class Heuristic:
    """
    Эвристическая проверка
    """

    @staticmethod
    def sigmoid(self, x):
        """ Функция сигмоиды """
        return 1 / (1 + math.exp(-x))
