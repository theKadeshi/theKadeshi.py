import unittest
import os
import modules.filesystem as fs


class TestFilesystemsMethods(unittest.TestCase):
	"""
	Тесты для модуля файловой системы
	"""
	
	wordpress_folder = "../mock/folder-02/wordpress-4.7.5/"
	
	def test_get_file_content(self):
		"""
		Проверка чтения содержимого файла
		"""
		
		function_result = fs.get_file_content(os.path.join(self.wordpress_folder, "index.php"))
		self.assertNotEqual(len(function_result), 0, "Файл не открылся")
		
		# Проверка на FileNotFoundError
		function_result = fs.get_file_content(os.path.join(self.wordpress_folder, "index2.php"))
		self.assertEqual(function_result, None, "Открылся, а не должен был")
