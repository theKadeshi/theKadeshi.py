import unittest
import modules.heuristic as heuristic


class TestHeuristicMethods(unittest.TestCase):
    """
    Класс проверки эвристического алгоритма
    """
    
    def test_get_hash_signatures(self):
        """
        Проверка вычисления измененной сигмоиды
        
        :return:
        """
        h = heuristic.Heuristic()
        result = h.sigmoid(1)
        # print(result)
        self.assertEqual(result, 0.2449186624037092, "Sigmoid function invalid")
    
    def test_validate_consonants_file_name(self):
        """
        Проверка работы функции отлова 7 согласных подряд в имени файла

        :return:
        """
        h = heuristic.Heuristic()
        file_name = "sdfjkhc76.php"  # 7 согласных подряд
        result = h.validate_consonants_file_name(file_name)
        self.assertEqual(result, 0.9413755384972873, "Warning level is incorrect")
    
    def test_validate_consonants_file_name_three_letters(self):
        """
        Проверка работы функции отлова 3 согласных подряд в имени файла

        :return:
        """
        h = heuristic.Heuristic()
        file_name = "sdduck76.com"  # 3 согласных подряд
        result = h.validate_consonants_file_name(file_name)
        self.assertEqual(result, 0, "Warning level is incorrect")
    
    def test_validate_consonants_file_name_fore_letters(self):
        """
        Проверка работы функции отлова 4 согласных подряд в имени файла

        :return:
        """
        h = heuristic.Heuristic()
        file_name = "msdduck76.com"  # 4 согласных подряд
        result = h.validate_consonants_file_name(file_name)
        self.assertEqual(result, 0.7615941559557646, "Warning level is incorrect")
    
    def test_validate_forbidden_functions_true(self):
        """
        Проверка работы функции поиска запрещенных слов в контенте

        :return:
        """
        
        h = heuristic.Heuristic()
        file_content = "print(eval(assert()));"
        result = h.validate_forbidden_functions(file_content)
        self.assertEqual(result.result, True, "Function warning is incorrect")
    
    def test_validate_forbidden_functions_false(self):
        """
        Проверка работы функции поиска запрещенных слов в контенте
        
        :return:
        """
        
        h = heuristic.Heuristic()
        file_content = "print(some(valid(function)));"
        result = h.validate_forbidden_functions(file_content)
        self.assertEqual(result.result, False, "Function warning is incorrect")
