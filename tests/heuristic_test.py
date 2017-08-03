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
    
    def test_convert_string_to_hex(self):
        """
        Тест перевода строки в hex
        
        :return:
        """
        h = heuristic.Heuristic()
        
        test_function = "assert"
        
        result = h.convert_string_to_hex(test_function)
        self.assertEqual(bytes(result, 'utf-8'), b'\\\\x61\\\\x73\\\\x73\\\\x65\\\\x72\\\\x74', "encode error")
    
    def test_convert_char_to_string(self):
        """
        Тест перевода chr(x) в строку
        :return:
        """
        h = heuristic.Heuristic()
        
        test_string = '$c968="p".chr(114)."e\x67".chr(95)."\x72ep".chr(108)."\x61\x63\x65";'
        
        result = h.convert_char_to_string(test_string)
        self.assertEqual(result, '$c968="preg_replace";')
    
    def test_convert_hex_to_string(self):
        """
        Тест перевода hex в строку
        
        :return:
        """
        h = heuristic.Heuristic()
        
        test_string = '"\\x64\\x64c8\\x63\\x384"'
        
        result = h.convert_hex_to_string(test_string)
        self.assertEqual(result, '"ddc8c84"')
    
    def test_convert_both(self):
        """
        Тест конвертирования обоих функций
        
        :return:
        """
        h = heuristic.Heuristic()
        
        test_string = '$btxv1=chr(47)."13".chr(101)."\\x64\\x64c8\\x63\\x384".chr(101).chr(49)."\\x31".chr(54).chr(102)."a".chr(51).chr(97).chr(49)."\\x369\\x33\\x66\\x30".chr(56).chr(49)."\\x37".chr(49).chr(56)."\\x39\\x30".chr(100)."/\\x65";'
        
        result = h.convert_hex_to_string(test_string)
        
        result = h.convert_char_to_string(result)
        
        self.assertEqual(result, '$btxv1=/13eddc8c84e116fa3a1693f08171890d/e";')
