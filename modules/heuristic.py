import math


class Heuristic:
    """
    Эвристическая проверка
    """
    
    consonants = ["b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "x", "v", "w", "z"]
    
    def sigmoid(self, x):
        """ Функция сигмоиды """
        return 2 / (1 + math.exp(-x / 2))
    
    def validate_file_name(self, file_name):
        """
        Функция проверки имени файла на стремность
        
        :param file_name: Имя файла
        :return:
        """
        warning_level = 0
        consonant_counter = 0
        temporary_warning_level = 0
        for letter in file_name:
            if letter in self.consonants:
                consonant_counter += 1
                
                if consonant_counter >= 3:
                    if consonant_counter > temporary_warning_level:
                        temporary_warning_level = consonant_counter
            else:
                consonant_counter = 0
        
        warning_level = self.sigmoid(temporary_warning_level)
        print(consonant_counter, temporary_warning_level, warning_level)
        return warning_level
