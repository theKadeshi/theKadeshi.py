import os
import re
import filesystem as fs_mod


class CMS:
    """
    Модуль определения CMS
    """
    
    __path = "./"
    
    def __init__(self, path="./"):
        """ Конструктор, судя по всему :) """
        self.__path = path
    
    def detect(self):
        """ Временная функция """
        file_list = self.get_files_list()
        dir_list = self.get_directories_list()
        result = {'cms': 'unknown', 'version': '0'}
        is_wordpress = self.is_it_wordpress(file_list, dir_list)
        is_joomla = self.is_it_joomla(file_list, dir_list)
        
        # @todo нужно окультурить эту проверку
        if is_wordpress['value'] > 3:
            result = {'cms': 'wordpress', 'version': is_wordpress['version']}
        
        if is_joomla['value'] > 3:
            result = {'cms': 'joomla', 'version': is_joomla['version']}
        
        return result
    
    def is_it_wordpress(self, file_list, dir_list):
        """
        Функция определения, является ли папка каталогом Wordpress
        
        :param file_list: Список файлов в каталоге
        :param dir_list: Список папок в каталоге
        :return: int
        """
        
        # Числовая вероятность того, что найденный сайт это вордпресс
        value = 0.0
        
        # Какие каталоги обычно присутствуют в корне вордпресса
        wordpress_folder_structure = ("wp-admin", "wp-content", "wp-includes")
        
        # Какие файлы обычно присутствуют в корне вордпресса
        wordpress_files_structure = (
            "index.php", "wp-settings.php", "wp-login.php",
            "wp-blog-header.php", "wp-cron.php", "wp-links-opml.php",
            "wp-mail.php", "wp-signup.php")
        
        # Файл с лицензией
        wordpress_license_file = "license.txt"
        
        # Файл с версией вордпресса
        wordpress_version_file = "wp-includes/version.php"
        
        # Предполагаемая версия вордпресса
        wordpress_version = "0"
        
        # Смотрим структуру каталогов и сравниваем ее со стандартной
        for directory in dir_list:
            # assert isinstance(wordpress_folder_structure, directory)
            if directory['name'] in wordpress_folder_structure:
                value = value + float(1 / len(wordpress_folder_structure))
        
        # Смотрим структуру файлов и сравниваем ее со стандартной
        for files in file_list:
            if files['name'] in wordpress_files_structure:
                value = value + float(1 / len(wordpress_files_structure))
            
            # Смотрим, есть ли файл с лицензией. Обычно в ней пишется многое о CMS :)
            if files['name'] == wordpress_license_file:
                file_content = fs_mod.FileSystem.get_file_content(files['path'])
                if file_content is not None:
                    if "https://wordpress.org/download/source/" in file_content:
                        value = value + 1
                    if "WordPress" in file_content:
                        value = value + 1
        
        # Смотрим, есть ли файл с версией.
        file_content = fs_mod.FileSystem.get_file_content(os.path.join(self.__path, wordpress_version_file))
        # print(file_content)
        if file_content is not None:
            if "WordPress" in file_content:
                value = value + 1
            version_regex = r"^\$wp_version\s{0,1}=\s{0,1}'(\d+.\d+(.\d+)?)';$"
            version_result = re.search(version_regex, str(file_content), re.MULTILINE | re.UNICODE | re.IGNORECASE)
            if version_result is not None:
                value = value + 1
                wordpress_version = version_result.group(1)
        return {'value': value, 'version': wordpress_version}
    
    def is_it_joomla(self, file_list, dir_list):
        """ Функция определения является ли CMS джумлой, мать ее """
        
        # Числовая вероятность того, что найденный сайт это джумла
        value = 0.0
        
        # Какие каталоги обычно присутствуют в корне джумлы
        joomla_folder_structure = (
            "administrator", "components", "includes", "language", "modules", "plugins", "cache", "cli", "libraries")
        
        # Какие файлы обычно присутствуют в корне джумлы
        joomla_files_structure = ("index.php", "LICENSE.txt", "README.txt")
        
        # Файл, где можно попробовать найти версию джумлы
        joomla_version_file = "administrator/manifests/files/joomla.xml"
        
        # Предположительная версия джумлы
        joomla_version = "0"
        
        # Смотрим структуру каталогов и сравниваем ее со стандартной
        for directory in dir_list:
            # assert isinstance(wordpress_folder_structure, directory)
            if directory['name'] in joomla_folder_structure:
                value = value + float(1 / len(joomla_folder_structure))
        
        # Смотрим структуру файлов и сравниваем ее со стандартной
        for files in file_list:
            if files['name'] in joomla_files_structure:
                value = value + float(1 / len(joomla_files_structure))
            
            # Смотрим, есть ли файл с лицензией. Обычно в ней пишется многое о CMS :)
            if files['name'] == "index.php":
                file_content = fs_mod.FileSystem.get_file_content(files['path'])
                if file_content is not None:
                    if "Joomla.Site" in file_content:
                        value = value + 1
                    if "define('_JEXEC', 1);" in file_content:
                        value = value + 1
        
        # Смотрим, есть ли файл с версией.
        file_content = fs_mod.FileSystem.get_file_content(os.path.join(self.__path, joomla_version_file))
        # print(file_content)
        if file_content is not None:
            if "Joomla!" in file_content:
                value = value + 1
            version_regex = r"^\s{0,}<version>(\d+\.\d+(\.\d+)?)<\/version>$"
            version_result = re.search(version_regex, file_content, re.MULTILINE | re.UNICODE | re.IGNORECASE)
            if version_result is not None:
                value = value + 1
                joomla_version = version_result.group(1)
        return {'value': value, 'version': joomla_version}
    
    def get_directories_list(self):
        """ Функция получения списка каталогов в заданном каталоге """
        directory_list = []
        for dirs in os.listdir(self.__path):
            dir_path = os.path.join(self.__path, dirs)
            if os.path.isdir(dir_path):
                directory_list.append({'path': dir_path, 'name': dirs})
        return directory_list
    
    def get_files_list(self):
        """ Функция получения списка файлов в каталоге """
        files_list = []
        for files in os.listdir(self.__path):
            file_path = os.path.join(self.__path, files)
            if os.path.isfile(file_path):
                files_list.append({'path': file_path, 'name': files})
        return files_list
