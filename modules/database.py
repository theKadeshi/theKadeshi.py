import sqlite3
import os
import re
from definitions import ROOT_DIR


class Database:
    base_path = os.path.join(ROOT_DIR, "database/thekadeshi.db")
    
    def get_hash_signatures(self):
        """
        Функция получения hash сигнатур из базы
        
        :return: Список сигнатур
        """
        
        signatures = []
        conn = sqlite3.connect(self.base_path)
        cursor = conn.cursor()
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
        
        conn.close()
        return signatures
    
    def get_regexp_signatures(self):
        """
        Функция получения списка регулярных сигнатур из базы
        
        :return: Список сигнатур
        """
        
        signatures = []
        conn = sqlite3.connect(self.base_path)
        cursor = conn.cursor()
        cursor.execute("""
            SELECT title, expression, flags, action, type, id
            FROM signatures_regexp
            WHERE status = 1 ORDER BY popularity DESC""")
        results = cursor.fetchall()
        
        # print(results)
        
        for result in results:
            flag = re.IGNORECASE
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
        
        conn.close()
        return signatures
