import unittest
import os
import modules.cms as cms_module


class TestCMSMethods(unittest.TestCase):
	"""
	Тесты для модуля определения CMS
	"""
	
	wordpress_folder = "../mock/folder-02/wordpress-4.7.5/"
	
	def test_is_it_wordpress(self):
		"""
		Проверка определения вордпресса в правильном каталоге
		"""
		
		if os.path.exists(self.wordpress_folder):
			cms = cms_module.CMS(self.wordpress_folder)
			directories_result = cms.get_directories_list()
			files_result = cms.get_files_list()
			cms_result = cms.is_it_wordpress(files_result, directories_result)
			value = cms_result['value']
			version = cms_result['version']
			self.assertEqual(value, 6, "Количество признаков не совпадает")
			self.assertEqual(version, "4.7.5", "Версия не совпадает")
	
	def test_is_it_wordpress_false(self):
		"""
		Проверка определения вордпресса в НЕ правильном каталоге
		Система НЕ должна определить тут вордпресс
		"""
		
		if os.path.exists("../mock/folder-02/joomla-2.5.8/"):
			cms = cms_module.CMS("../mock/folder-02/joomla-2.5.8/")
			directories_result = cms.get_directories_list()
			files_result = cms.get_files_list()
			cms_result = cms.is_it_wordpress(files_result, directories_result)
			value = cms_result['value']
			version = cms_result['version']
			# print(cms_result)
			self.assertLess(value, 1, "Количество признаков не совпадает")
			self.assertNotEqual(version, "4.7.5", "Версия не совпадает")
	
	def test_is_it_joomla(self):
		"""
		Проверка определения ждумлы в правильном каталоге
		"""
		
		cms_folder = "../mock/folder-02/joomla-3.7.2/"
		if os.path.exists(cms_folder):
			cms = cms_module.CMS(cms_folder)
			directories_result = cms.get_directories_list()
			files_result = cms.get_files_list()
			cms_result = cms.is_it_joomla(files_result, directories_result)
			value = cms_result['value']
			version = cms_result['version']
			# print(cms_result)
			self.assertEqual(value, 6, "Количество признаков не совпадает")
			self.assertEqual(version, "3.7.2", "Версия не совпадает")
	
	def test_is_it_joomla_false(self):
		"""
		Проверка определения джумлы в НЕ правильном каталоге
		Система НЕ должна определить тут джумлу
		"""
		
		cms_folder = "../mock/folder-02/wordpress-2.7/"
		if os.path.exists(cms_folder):
			cms = cms_module.CMS(cms_folder)
			directories_result = cms.get_directories_list()
			files_result = cms.get_files_list()
			cms_result = cms.is_it_joomla(files_result, directories_result)
			value = cms_result['value']
			version = cms_result['version']
			print(cms_result)
			self.assertLess(value, 1, "Количество признаков не совпадает")
			self.assertNotEqual(version, "4.7.5", "Версия не совпадает")
			
	def test_get_directories_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		
		cms = cms_module.CMS(self.wordpress_folder)
		function_result = cms.get_directories_list()
		self.assertEqual(len(function_result), 3, "Спсиок каталогов не соответствует ожиданиям")
	
	def test_get_files_list(self):
		"""
		Проверка работоспособности функции получения списка каталогов
		"""
		
		cms = cms_module.CMS(self.wordpress_folder)
		function_result = cms.get_files_list()
		self.assertEqual(len(function_result), 16, "Спсиок файлов не соответствует ожиданиям")
	
	def test_detect_wordpress_fore(self):
		""" Проверка определения вордпресса версии 4.7.5 """
		
		if os.path.exists("../mock/folder-02/wordpress-4.7.5/"):
			cms = cms_module.CMS(self.wordpress_folder)
			function_result = cms.detect()
			# print(function_result)
			self.assertEqual(function_result['cms'], 'wordpress', "CMS определена не правильно")
			self.assertEqual(function_result['version'], '4.7.5', "Версия CMS определена не правильно")
	
	def test_detect_wordpress_three(self):
		""" Проверка определения вордпресса версии 3.8 """
		
		if os.path.exists("../mock/folder-02/wordpress-3.8/"):
			cms = cms_module.CMS("../mock/folder-02/wordpress-3.8/")
			function_result = cms.detect()
			# print(function_result)
			self.assertEqual(function_result['cms'], 'wordpress', "CMS определена не правильно")
			self.assertEqual(function_result['version'], '3.8', "Версия CMS определена не правильно")
	
	def test_detect_wordpress_two(self):
		""" Проверка определения вордпресса версии 2.7 """
		
		if os.path.exists("../mock/folder-02/wordpress-2.7/"):
			cms = cms_module.CMS("../mock/folder-02/wordpress-2.7/")
			function_result = cms.detect()
			# print(function_result)
			self.assertEqual(function_result['cms'], 'wordpress', "CMS определена не правильно")
			self.assertEqual(function_result['version'], '2.7', "Версия CMS определена не правильно")
	
	def test_detect_joomla_three(self):
		""" Проверка определения вордпресса версии 3.7.2 """
		
		cms_folder = "../mock/folder-02/joomla-3.7.2/"
		if os.path.exists(cms_folder):
			cms = cms_module.CMS(cms_folder)
			function_result = cms.detect()
			# print(function_result)
			self.assertEqual(function_result['cms'], 'joomla', "CMS определена не правильно")
			self.assertEqual(function_result['version'], '3.7.2', "Версия CMS определена не правильно")
	
	def test_detect_joomla_two(self):
		""" Проверка определения вордпресса версии 2.5.28 """
		
		cms_folder = "../mock/folder-02/joomla-2.5.8/"
		if os.path.exists(cms_folder):
			cms = cms_module.CMS(cms_folder)
			function_result = cms.detect()
			# print(function_result)
			self.assertEqual(function_result['cms'], 'joomla', "CMS определена не правильно")
			self.assertEqual(function_result['version'], '2.5.28', "Версия CMS определена не правильно")
if __name__ == '__main__':
	unittest.main()
