import sqlite3
import os
from definitions import ROOT_DIR


class Database:
    base_path = os.path.join(ROOT_DIR, "database/thekadeshi.db")
    
    def get_hash_signatures(self):
        signatures = []
        conn = sqlite3.connect(self.base_path)
        cursor = conn.cursor()
        cursor.execute("SELECT title, hash, action FROM signatures_hash WHERE status = 1")
        results = cursor.fetchall()
        
        # print(results)
        
        for result in results:
            signatures.append({'title': result[0], 'expression': result[1], 'action': result[2]})
        
        conn.close()
        return signatures
