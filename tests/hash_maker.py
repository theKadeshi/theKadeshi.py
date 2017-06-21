import hashlib

with open("../mock/virus0253.php", mode='rb') as f:
    # Тут у нас обработчик ошибок.
    try:
        content = f.read()
    
    # Это если в коде внезапно нашелся недопустимый символ.
    except UnicodeDecodeError as e:
        is_file_error = True
        print("Incorrect char in file", e)
    
    # Если нет ошибок чтения, то сканируем
    if len(content) > 0:
        # No need to check if database is absent
        # if self.database_present:
        # Хеш сумма файла
        file_hash: str = hashlib.sha256(content).hexdigest()

print(file_hash)
