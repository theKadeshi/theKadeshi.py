import sqlite3
import os
from definitions import ROOT_DIR

base_path = os.path.join(ROOT_DIR, "database/thekadeshi.db")
print(base_path)

def get_hash_signatures():
	global base_path
	
	conn = sqlite3.connect(base_path)
	
	cursor = conn.cursor()
	
	cursor.execute("select title, hash, action from signatures_hash where status = 1")
	
	results = cursor.fetchall()
	
	print(results)
	
	conn.close()
