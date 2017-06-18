import sqlite3
import os
import re
from definitions import ROOT_DIR


class Database:
    """
    Database class
    """
    
    base_path: str = ""
    
    conn = None
    
    def __init__(self):
        """
        Constructor
        """
        
        prefix_folders: list = ["./", "./database/", "../"]
        
        database_present: bool = False
        
        for prefix_folder in prefix_folders:
            current_base_path: str = os.path.join(ROOT_DIR, prefix_folder + "thekadeshi.db")
            if os.path.isfile(current_base_path):
                database_present = True
                self.base_path = current_base_path
                break
        
        if not database_present:
            print("Error. Database not found.")
            exit(101)  # Database not found
        try:
            self.conn = sqlite3.connect(self.base_path)
        except sqlite3.OperationalError as e:
            print("Database error", e)
            exit(102)  # Database connection error
    
    def get_hash_signatures(self):
        """
        Функция получения hash сигнатур из базы
        
        :return: Список сигнатур
        :rtype: list
        """
        
        signatures: list = []
        # conn = sqlite3.connect(self.base_path)
        cursor = self.conn.cursor()
        cursor.execute(
            "SELECT title, hash, action, type, id FROM signatures_hash WHERE status = 1 ORDER BY popularity DESC")
        results = cursor.fetchall()
        
        # print(results)
        
        for result in results:
            signatures.append({
                'id': result[4],
                'title': "KDSH." + result[3].upper() + "." + result[0],
                'expression': result[1],
                'action': result[2]
            })
        
        return signatures
    
    def get_regexp_signatures(self):
        """
        Функция получения списка регулярных сигнатур из базы
        
        :return: Список сигнатур
        :rtype: list
        """
        
        signatures: list = []
        # conn = sqlite3.connect(self.base_path)
        cursor = self.conn.cursor()
        cursor.execute("""
            SELECT title, expression, flags, action, type, id
            FROM signatures_regexp
            WHERE status = 1 ORDER BY popularity DESC""")
        results = cursor.fetchall()
        
        # print(results)
        
        for result in results:
            flag = re.IGNORECASE
            if result[2] == 'im':
                flag = re.IGNORECASE | re.MULTILINE
            if result[2] == 'is':
                flag = re.IGNORECASE | re.DOTALL
            if result[2] == 's':
                flag = re.DOTALL | re.UNICODE
            signatures.append({
                'id': result[5],
                'title': "KDSH." + result[4].upper() + "." + result[0],
                'expression': re.compile(result[1], flag),
                'flag': result[2],
                'action': result[3]
            })
        
        # conn.close()
        return signatures
    
    def __exit__(self, exception_type, exception_value, traceback):
        """
        Destructor
        
        :return:
        """
        
        self.conn.close()
