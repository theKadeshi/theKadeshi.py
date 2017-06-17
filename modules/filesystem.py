class FileSystem:
    def get_file_content(self, file_path: str):
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
    
    def put_file_content(self, file_path: str, file_content: bytearray):
        result = True
        try:
            with open(file_path, mode="wb") as f:
                f.write(file_content)
                f.close()
        except:
            result = False
        return result
