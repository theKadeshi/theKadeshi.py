import unittest
import os
import modules.cms as cms_module


class TestCMSMethods(unittest.TestCase):
	"""
	Тесты для модуля определения CMS
	"""
	
	wordpress_folder = "../mock/folder-02/wordpress/"
	
	def test_is_it_wordpress(self):
		"""
		Проверка определения вордпресса в правильном каталоге
		"""
		# global wordpress_folder
		cms = cms_module.CMS(self.wordpress_folder)
		directories_result = cms.get_directories_list()
		files_result = cms.get_files_list()
		cms_result = cms.is_it_wordpress(files_result, directories_result)
		value = cms_result['value']
		version = cms_result['version']
		self.assertEqual(value, 6, "Количество признаков не совпадает")
		self.assertEqual(version, "4.7.5", "Версия не совпадает")
	
	def test_get_directories_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		# global wordpress_folder
		cms = cms_module.CMS(self.wordpress_folder)
		function_result = cms.get_directories_list()
		self.assertEqual(len(function_result), 3, "Спсиок каталогов не соответствует ожиданиям")
	
	def test_get_files_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		# global wordpress_folder
		cms = cms_module.CMS(self.wordpress_folder)
		function_result = cms.get_files_list()
		self.assertEqual(len(function_result), 16, "Спсиок файлов не соответствует ожиданиям")

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
