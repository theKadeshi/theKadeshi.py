import unittest
import modules.heuristic as heuristic


class TestHeuristicMethods(unittest.TestCase):
    """
    Класс проверки эвристического алгоритма
    """
    
    def test_get_hash_signatures(self):
        """
        Пустая функция проверки. Задел на будущее
        
        :return:
        """
        h = heuristic.Heuristic()
        result = h.sigmoid(1)
        print(result)
        self.assertEqual(result, 0.7310585786300049, "Sigmoid function invalid")

    def test_validate_file_name(self):
        h = heuristic.Heuristic()
        file_name = "sdfjkhc76.php" # 7 согласных подряд
        result = h.validate_file_name(file_name)
        self.assertEqual(result, 0.9990889488055994, "Warning level is incorrect")
