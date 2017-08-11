import math
import re


class IHeuristicCheckResult:
    """
    Empty check result structure
    """

    # Check result
    result: bool

    # What was detected
    detected: str

    # Where it was detected
    position: int

    def __init__(self):
        self.result = False
        self.detected = None
        self.position = None


class Heuristic:
    """
    Эвристическая проверка
    """

    # Consonant letters
    consonants: list = ["b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "x", "v", "w",
                        "z"]

    # Dangerous PHP functions
    forbidden_functions: list = ["eval", "assert", "base64_decode", "str_rot13", "mail",
                                 "move_uploaded_file", "is_uploaded_file", "script",
                                 "fopen", "curl_init", "document.write", "$GLOBAL",
                                 "passthru", "system", "exec", "header", "preg_replace",
                                 "fromCharCode", "$_COOKIE", "$_POST", "$_GET", "copy", "navigator",
                                 "$_REQUEST", "array_filter", "str_replace", "refresh", "invokeArgs",
                                 "php://input"]

    @staticmethod
    def sigmoid(x: float):
        """
        Modified sigmoid function

        :param x: Some value
        :type x: float
        :return: Some value between 0 and 1
        :rtype: float
        """
        return 2 / (1 + math.exp(-x / 2)) - 1

    def validate_content(self, file_content: str):
        """
        Heuristic detection

        :param file_content: File text content
        :type file_content: str
        :return:
        :rtype: IHeuristicCheckResult
        """
        result = self.validate_long_words(file_content)

        if not result.result:
            result: IHeuristicCheckResult = self.validate_forbidden_functions(file_content)

        return result

    def validate_consonants_file_name(self, file_name: str):
        """
        Validate file name

        :param file_name: File name
        :type file_name: str
        :return:
        :rtype: float
        """

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

        return warning_level

    @staticmethod
    def validate_long_words(file_content: str):
        """
        Looking for long words in file content

        :param file_content: File content
        :type file_content: str
        :return:
        :rtype: IHeuristicCheckResult
        """

        check_result: IHeuristicCheckResult = IHeuristicCheckResult()
        words_list = re.split('[.,/;:"\'!?(){}\[\]%$#@^&*+=<>\\\ |\d]+', str(file_content))
        for word in words_list:
            if len(word) > 25:
                word_position = file_content.find(word)
                check_result.result = True
                check_result.detected = 'Long word'
                check_result.position = word_position
                break

        return check_result

    def validate_forbidden_functions(self, file_content: str):
        """
        Validate file content for the forbidden functions

        :param file_content: File content
        :type file_content: str
        :return: Validation result
        :rtype: IHeuristicCheckResult
        """

        check_result: IHeuristicCheckResult = IHeuristicCheckResult()

        for func in self.forbidden_functions:
            function_position: int = file_content.find(func)
            if function_position != -1:
                check_result.result = True
                check_result.position = function_position
                check_result.detected = func
                break
            else:
                file_content = self.convert_char_to_string(file_content)
                file_content = self.convert_hex_to_string(file_content)

                # function_position: int = file_content.find(self.convert_string_to_hex(func))
                function_position: int = file_content.find(func)
                if function_position != -1:
                    check_result.result = True
                    check_result.position = function_position
                    check_result.detected = func
                    break

        return check_result

    @staticmethod
    def convert_string_to_hex(function_string: str):
        """
        Temporary unused function

        :param function_string:
        :return:
        """
        result: str = ""
        for char in str.encode(function_string, 'ascii'):
            # print (char)
            result += "\\\\x" + str(hex(char)).replace("0x", "")

        return result

    @staticmethod
    def convert_char_to_string(content: str):
        char_reges = [
            re.compile(r"([\"']?\s?\.?\s?chr\(([0-9]{2,3})\)\s?\.?\s?[\"']?)", re.IGNORECASE),
        ]
        empty_key_array = []
        for char_reg in char_reges:
            # compiled_regex = re.compile(char_reg, re.IGNORECASE)
            result = re.findall(char_reg, content)
            if result:
                for result_element in result:
                    found_char_value = result_element[0]
                    if found_char_value not in empty_key_array:
                        new_char = chr(int(result_element[1]))
                        content = content.replace(found_char_value, new_char)

                        empty_key_array.append(found_char_value)

        return content

    @staticmethod
    def convert_hex_to_string(content: str):
        char_reg = r"(\\x([a-h0-9]{2}))"
        compiled_regex = re.compile(char_reg, re.IGNORECASE)
        result = re.findall(compiled_regex, content)
        empty_key_array = []
        if result:
            # print(result)
            for result_element in result:
                found_char_value = result_element[0]
                if found_char_value not in empty_key_array:
                    new_char = chr(int(result_element[1], 16))
                    content = content.replace(found_char_value, new_char)

                    empty_key_array.append(found_char_value)

        return content
