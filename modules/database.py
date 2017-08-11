import sqlite3
import os
import re
import datetime
from definitions import ROOT_DIR


class Database:
    """
    Database class
    """

    base_path: str = ""

    conn = None

    # Флаг работы без базы
    no_database: bool = False

    def __init__(self):
        """
        Constructor
        """

        prefix_folders = ["./", "./database/", "../"]
        database_present: bool = False
        for prefix_folder in prefix_folders:
            current_base_path: str = os.path.join(ROOT_DIR, prefix_folder + "thekadeshi.db")
            if os.path.isfile(current_base_path):
                database_present = True
                self.base_path = current_base_path
                break

        if not database_present:
            print("Error 101. Database not found.")
            self.no_database = True
        try:
            self.conn = sqlite3.connect(self.base_path)
        except sqlite3.OperationalError as e:
            print("Error 102. Database error", e)
            self.no_database = True

        if self.no_database:
            print("Heuristic check only")

    def get_hash_signatures(self):
        """
        Функция получения hash сигнатур из базы

        :return: Список сигнатур
        :rtype: list
        """

        signatures: list = []

        if not self.no_database:

            cursor = self.conn.cursor()

            cursor.execute("""SELECT title, hash, action, type, id 
                              FROM signatures_hash 
                              WHERE status = 1 
                              ORDER BY popularity DESC""")

            results = cursor.fetchall()

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

        if not self.no_database:

            cursor = self.conn.cursor()

            cursor.execute("""
                SELECT title, expression, flags, action, type, id, min_size, max_size
                FROM signatures_regexp
                WHERE status = 1 ORDER BY popularity DESC, action DESC""")

            results = cursor.fetchall()

            for result in results:
                flag = re.IGNORECASE
                if result[2] == 'ims':
                    flag = re.IGNORECASE | re.MULTILINE | re.DOTALL
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
                    'min_size': result[6],
                    'max_size': result[7],
                    'flag': result[2],
                    'action': result[3]
                })

        return signatures

    def write_statistic(self, signature):
        """
        Write signature statistic usage

        :param signature:
        :return:
        """
        current_date = int(datetime.datetime.now().timestamp() * 100)
        cursor = self.conn.cursor()

        print(signature)

        check_query = """
        SELECT id, signature_id, max_file_size, min_file_size, min_signature_size, max_signature_size, scanned_times 
        FROM signatures_statistics 
        WHERE signature_id = ? 
        LIMIT 0, 1"""

        cursor.execute(check_query, (signature['signature_id'],))

        results = cursor.fetchone()

        print(results)

        if 'size' not in signature or signature['size'] is None:
            signature['size'] = 0

        if 'length' not in signature or signature['length'] is None:
            signature['length'] = 0

        if results is None:
            values = ([str(signature['id']), str(signature['size']), str(signature['size']),
                       str(signature['length']), str(signature['length']),
                       str(current_date)],)

            query = """
               INSERT INTO signatures_statistics(
                    signature_id, 
                    min_file_size, max_file_size, 
                    min_signature_size, max_signature_size, 
                    scanned_times, created_at) 
               VALUES (?, ?, ?, ?, ?, 1, ?)"""

            cursor.execute(query, values)
            self.conn.commit()
        else:
            if signature['size'] < results[2]:
                new_min_file_size: int = signature['size']
            else:
                new_min_file_size = results[2]

            if signature['size'] > results[3]:
                new_max_file_size: int = signature['size']
            else:
                new_max_file_size = results[3]

            if signature['length'] < results[4]:
                new_min_signature_size: int = signature['cure']['length']
            else:
                new_min_signature_size = results[4]

            if signature['length'] > results[5]:
                new_max_signature_size: int = signature['core']['length']
            else:
                new_max_signature_size = results[5]

            new_scanned_times: int = int(results[6]) + 1

            query = "UPDATE signatures_statistics set " + \
                    "min_file_size=" + str(new_min_file_size) + ", " + \
                    "min_file_size=" + str(new_min_file_size) + ", " + \
                    "max_file_size=" + str(new_max_file_size) + ", " + \
                    "min_signature_size=" + str(new_min_signature_size) + ", " + \
                    "max_signature_size=" + str(new_max_signature_size) + ", " + \
                    "scanned_times=" + str(new_scanned_times) + ", " + \
                    "updated_at='" + str(current_date) + "' " + \
                    "where signature_id=" + str(signature['signature_id'])

            cursor.execute(query)
            self.conn.commit()

    def __exit__(self, exception_type, exception_value, traceback):
        """
        Destructor

        :return:
        """

        if not self.no_database:
            self.conn.close()
