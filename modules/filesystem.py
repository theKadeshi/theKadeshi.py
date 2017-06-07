def get_file_content(file_path):
    """
    Функция получения содержимого файла.
    Ошибки замалчиваютя, потому что делать с ними пока нечего

    :param file_path: Путь к файлу
    :return: Содержимое файла или None
    """
    
    file_content = None
    try:
        with open(file_path, encoding="latin-1") as f:
            file_content = f.read()
    except FileNotFoundError as e:
        # print("FileNotFoundError", e)
        pass
    
    return file_content
