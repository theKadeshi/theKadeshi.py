"""
Модуль определения CMS
"""
import os, re


def detect(path="./"):
	file_list = get_files_list(path)
	dir_list = get_directories_list(path)
	
	is_wordpress = is_it_wordpress(file_list, dir_list)
	return is_wordpress


def is_it_wordpress(file_list, dir_list):
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
	
	# Файл ридми, из которого можно узнать номер версии
	wordpress_readme_file = "readme.html"
	
	# Предполагаемая версия вордпресса
	wordpress_version = 0
	result = False
	
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
			with open(files['path'], encoding="utf-8") as f:
				try:
					# @!fixme! Надо отрефакторить!
					file_content = f.read()
					
					if "https://wordpress.org/download/source/" in file_content:
						value = value + 1
					if "WordPress" in file_content:
						value = value + 1
				except UnicodeDecodeError as e:
					# @todo:ntorgov Надо что-то сюда вставить для культуры
					pass
		if files['name'] == wordpress_readme_file:
			with open(files['path'], encoding="utf-8") as f:
				try:
					# @!fixme! Надо отрефакторить!
					file_content = f.read()
					
					if "WordPress" in file_content:
						value = value + 1
					
					version_regex = r'^\s{0,}(<br\s{0,1}\/>)?\s{0,1}(Version)\s{0,1}(\d+\.\d+)$'
					version_result = re.search(version_regex, file_content, re.MULTILINE | re.UNICODE | re.IGNORECASE)
					if version_result is not None:
						value = value + 1
						wordpress_version = version_result.group(3)
				except UnicodeDecodeError as e:
					# @todo:ntorgov Надо что-то сюда вставить для культуры
					pass
	
	return {'value': value, 'version': wordpress_version}


def get_directories_list(path="./"):
	""" Функция получения списка каталогов в заданном каталоге """
	directory_list = []
	for dirs in os.listdir(path):
		dir_path = os.path.join(path, dirs)
		if os.path.isdir(dir_path):
			directory_list.append({'path': dir_path, 'name': dirs})
	return directory_list


def get_files_list(path="./"):
	""" Функция получения списка файлов в каталоге """
	files_list = []
	for files in os.listdir(path):
		file_path = os.path.join(path, files)
		if os.path.isfile(file_path):
			files_list.append({'path': file_path, 'name': files})
	return files_list
