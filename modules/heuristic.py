import math


class Heuristic:
    """
    Эвристическая проверка
    """
    
    consonants: list = ["b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "x", "v", "w", "z"]
    
    forbidden_functions: list = ["eval", "assert", "base64_decode", "str_rot13", "mail",
                                 "move_uploaded_file", "is_uploaded_file", "script",
                                 "fopen", "curl_init", "document.write", "$GLOBAL",
                                 "passthru", "system", "exec", "header", "preg_replace",
                                 "fromCharCode", "$_COOKIE", "$_POST", "$_GET", "copy", "navigator",
                                 "$_REQUEST", "array_filter", "str_replace"]
    
    def sigmoid(self, x: float):
        """
        Modified sigmoid function
        
        :param x: Some value
        :type x: float
        :return: Some value between 0 and 1
        :rtype: float
        """
        return 2 / (1 + math.exp(-x / 2)) - 1
    
    def validate_consonants_file_name(self, file_name: str):
        """
        Validate file name
        
        :param file_name: File name
        :type file_name: str
        :return:
        :rtype: float
        """
        
        warning_level: float = 0
        consonant_counter: int = 0
        temporary_warning_level: int = 0
        for letter in file_name:
            if letter in self.consonants:
                consonant_counter += 1
                
                if consonant_counter > 3:
                    if consonant_counter > temporary_warning_level:
                        temporary_warning_level = consonant_counter
            else:
                consonant_counter = 0
        
        warning_level = self.sigmoid(temporary_warning_level)
        # print(consonant_counter, temporary_warning_level, warning_level)
        return warning_level
    
    def validate_forbidden_functions(self, file_content: str):
        """
        Validate file content for the forbidden functions
        
        :param file_content: File content
        :type file_content: str
        :return: Validation result
        :rtype: bool
        """
        
        result: bool = False
        
        for func in self.forbidden_functions:
            if file_content.find(func) != -1:
                result = True
                break
        
        return result
