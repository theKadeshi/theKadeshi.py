import unittest
import os
import modules.cms as cms


class TestCMSMethods(unittest.TestCase):
	"""
	Тесты для модуля определения CMS
	"""
	
	wordpress_folder = "../mock/folder-02/wordpress/"
	
	def test_is_it_wordpress(self):
		"""
		Проверка определения вордпресса в правильном каталоге
		"""
		global wordpress_folder
		directories_result = cms.get_directories_list(self.wordpress_folder)
		files_result = cms.get_files_list(self.wordpress_folder)
		cms_result = cms.is_it_wordpress(files_result, directories_result)
		value = cms_result['value']
		version = cms_result['version']
		self.assertEqual(value, 6, "Количество признаков не совпадает")
		self.assertEqual(version, "4.7", "Версия не совпадает")
	
	def test_get_directories_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		global wordpress_folder
		function_result = cms.get_directories_list(self.wordpress_folder)
		self.assertEqual(len(function_result), 3, "Спсиок каталогов не соответствует ожиданиям")
	
	def test_get_files_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		global wordpress_folder
		function_result = cms.get_files_list(self.wordpress_folder)
		self.assertEqual(len(function_result), 16, "Спсиок файлов не соответствует ожиданиям")
	
	def test_get_file_content(self):
		"""
		Проверка чтения содержимого файла
		"""
		global wordpress_folder
		function_result = cms.get_file_content(os.path.join(self.wordpress_folder, "index.php"))
		self.assertNotEqual(len(function_result), 0, "Файл не открылся")
		
		# Проверка на FileNotFoundError
		function_result = cms.get_file_content(os.path.join(self.wordpress_folder, "index2.php"))
		self.assertEqual(function_result, None, "Открылся, а не должен был")


# def test_isupper(self):
#     self.assertTrue('FOO'.isupper())
#     self.assertFalse('Foo'.isupper())
#
# def test_split(self):
#     s = 'hello world'
#     self.assertEqual(s.split(), ['hello', 'world'])
#     # check that s.split fails when the separator is not a string
#     with self.assertRaises(TypeError):
#         s.split(2)


if __name__ == '__main__':
	unittest.main()
