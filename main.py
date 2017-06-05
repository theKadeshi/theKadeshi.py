import os
import json, requests

filesList = []

# Список расширений, которые будут сканироваться
permittedExtensions = (".php", ".js", ".htm", ".html")


def get_files_list():
	"""
	Функция получения списка файлов

	:return: Какое-то значение
	"""
	for root, dirs, files in os.walk('./'):
		for name in files:
			if name.endswith(permittedExtensions):
				filesList.append(name)
				print(name)

	return 1


def get_remote_signatures():
	"""
	Функция получения удаленных сигнатур
	:return: Нихрена
	"""
	r = requests.post('http://thekadeshi.com/api/getSignatures', data={'notoken': '1'})
	json_result = r.json()
	print(json_result)


get_remote_signatures()

# get_files_list()

print(filesList)
