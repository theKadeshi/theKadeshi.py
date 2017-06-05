import os
import json, requests
import hashlib

filesList = []

# Список расширений, которые будут сканироваться
permittedExtensions = (".php", ".js", ".htm", ".html")

# База сигнатур
signatureDatabase = ""


def get_files_list():
	"""
	Функция получения списка файлов

	:return: Какое-то значение
	"""
	global filesList
	for root, dirs, files in os.walk('./'):
		for name in files:
			if name.endswith(permittedExtensions):
				filesList.append(os.path.join(root, name))
				# print(name)

	return 1


def get_remote_signatures():
	"""
	Функция получения удаленных сигнатур
	:return: Нихрена
	"""
	global signatureDatabase
	r = requests.post('http://thekadeshi.com/api/getSignatures', data={'notoken': '1'})
	signatureDatabase = r.json()


# signatureDatabase = json_result
# print(signatureDatabase)
# print(signatureDatabase['r'])


def scan_files():
	global signatureDatabase

	need_to_scan = True

	# Берем файл из списка
	for file_item in filesList:
		with open(file_item) as f:
			content = f.read()

			file_hash = hashlib.sha224(str.encode(content)).hexdigest()
			print(file_hash)

			# Берем сигнатуру из списка
			for signature in signatureDatabase['r']:
				print(signature)


get_remote_signatures()

get_files_list()

scan_files()

print(filesList)
