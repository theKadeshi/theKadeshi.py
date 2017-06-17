class FileSystem:
    """
    Filesystem class
    """
    
    @staticmethod
    def get_file_content(file_path: str):
        """
        Функция получения содержимого файла.
        Ошибки замалчиваютя, потому что делать с ними пока нечего
        
        :param file_path: Путь к файлу
        :type file_path: str
        :return: Содержимое файла или None
        :rtype: bytearray
        """
        
        file_content = None
        try:
            with open(file_path, mode="rb") as f:
                file_content = f.read()
                f.close()
        except FileNotFoundError as e:
            # print("FileNotFoundError", e)
            pass
        
        return file_content
    
    @staticmethod
    def put_file_content(file_path: str, file_content: bytes):
        """
        Write content into file
        
        :param file_path: File path
        :type file_path: str
        :param file_content: File content
        :type file_content: bytes
        :return:
        """
        
        result: bool = True
        try:
            with open(file_path, mode="wb") as f:
                f.write(file_content)
                f.close()
        except:
            result = False
        return result
