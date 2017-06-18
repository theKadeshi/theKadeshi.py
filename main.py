#!/usr/bin/env python

import os
# import json, requests
import hashlib
import time
import re
import argparse
# import modules.cms as cms
import modules.database as dbase
import modules.report as report
import modules.colors as cls
import modules.filesystem as fsys
import modules.heuristic as h_mod

# Список расширений, которые будут сканироваться
permitted_extensions = (".php", ".js", ".htm", ".html", "pl")


class TheKadeshi:
    """
    Основной класс
    """
    
    # Список зараженных файлов
    anamnesis_list: list = []
    
    # Список файлов для сканирования
    files_list: list = []
    
    # Суммарный размер файлов в байтах
    total_files_size: int = 0
    
    # База сигнатур
    signatures_database = {'h': [], 'r': []}
    
    # No database. Heuristic scan only
    database_present: bool = True
    
    # site_path: str = "./", no_color: bool = False, no_heuristic: bool = False
    def __init__(self, arguments):
        """
        Scanner initialization
        
        :param arguments: Scanner arguments
        :type arguments: object{}
        """
        
        self.site_folder: str = arguments.site
        self.no_color: bool = arguments.no_color
        self.no_heuristic: bool = arguments.no_heuristic
    
    def get_files_list(self):
        """
        Функция получения списка файлов
        
        :return: Ничего, просто заполняет список файлов
        """
        
        for root, dirs, files in os.walk(self.site_folder):
            for name in files:
                if name.endswith(permitted_extensions):
                    file_path: str = os.path.join(root, name)
                    file_size: int = os.path.getsize(file_path)
                    self.total_files_size = self.total_files_size + file_size
                    self.files_list.append({'path': file_path, 'size': file_size})
    
    def load_signatures(self):
        """
        Функция загрузки сигнатур
        """
        
        db = dbase.Database()
        self.signatures_database['h'] = db.get_hash_signatures()
        self.signatures_database['r'] = db.get_regexp_signatures()
        
        if len(self.signatures_database['h']) == 0 and len(self.signatures_database['h']) == 0:
            self.database_present = False
    
    def scan_files(self):
        """
        Функция сканирования файлов
        
        :return: Ничего
        """
        
        # Таймер
        timer_start: float = time.time()
        
        # Сколько просканировано в байтах, необходимо для вычисления скорости
        total_scanned: int = 0
        
        # Расчетная скорость сканирования
        scan_speed: float = 0
        
        # Счетчик проверенных файлов
        scanner_counter: int = 0
        
        heuristic = h_mod.Heuristic()
        # Берем файл из списка
        for file_item in self.files_list:
            anamnesis_element: list = []
            current_progress = (total_scanned + file_item['size']) * 100 / self.total_files_size
            
            is_file_clean: bool = True
            
            is_file_error: bool = False
            
            # Флаг, нужно ли продолжать сканирование
            need_to_scan: bool = True
            
            # with open(file_item['path'], encoding="latin-1", mode='rb') as f:
            with open(file_item['path'], mode='rb') as f:
                
                # Тут у нас обработчик ошибок.
                try:
                    content = f.read()
                
                # Это если в коде внезапно нашелся недопустимый символ.
                except UnicodeDecodeError as e:
                    is_file_error = True
                    print("Incorrect char in ", file_item['path'], e)
                
                # Если нет ошибок чтения, то сканируем
                if len(content) > 0:
                    
                    # No need to check if database is absent
                    if self.database_present:
                        # Хеш сумма файла
                        file_hash: str = hashlib.sha256(content).hexdigest()
                        
                        # if len(self.signatures_database['h']) > 0:
                        for signature in self.signatures_database['h']:
                            if file_hash == signature['expression']:
                                
                                is_file_clean = False
                                
                                anamnesis_element = {
                                    'id': signature['id'],
                                    'type': 'h',
                                    'path': file_item['path'],
                                    'title': signature['title'],
                                    'action': signature['action']
                                }
                                
                                if signature['action'] == 'delete':
                                    need_to_scan = False
                                
                                # Прерываем цикл
                                break
                
                # Heuristic mode is On
                if not self.no_heuristic and not self.database_present:
                    heuristic_result = heuristic.validate_forbidden_functions(str(content))
                    if not heuristic_result['result']:
                        need_to_scan = False
                
                if need_to_scan and self.database_present:
                    
                    # Если сканирование по хэш ничего не выявило, то ищем по сигнатурам
                    # if len(self.signatures_database['r']):
                    try:
                        string_content = content.decode('utf-8')
                    except UnicodeDecodeError as e:
                        string_content = content.decode('latin-1')
                    
                    for signature in self.signatures_database['r']:
                        matches = re.search(signature['expression'], string_content)
                        if matches is not None:
                            need_to_scan = False
                            is_file_clean = False
                            start_position = matches.span()[0]
                            end_position = matches.span()[1]
                            
                            anamnesis_element = {
                                'id': signature['id'],
                                'type': 'r',
                                'path': file_item['path'],
                                'title': signature['title'],
                                'action': signature['action'],
                                'cure': {'start': start_position, 'end': end_position}
                            }
                            # Прерываем цикл
                            break
                else:
                    # Очевидно с базой что-то не так
                    heuristic_check_only = True
                    pass
            f.close()
            
            total_scanned = total_scanned + file_item['size']
            current_time = time.time()
            time_delta = current_time - timer_start
            if time_delta != 0:
                scan_speed = total_scanned // time_delta // 1024
            scanner_counter = scanner_counter + 1
            
            file_message: str = cls.C_GREEN + "Clean" + cls.C_DEFAULT
            if self.no_color:
                file_message = "Clean"
            
            if is_file_error:
                file_message = "Error"
            else:
                if self.database_present:
                    if not is_file_clean:
                        file_message = cls.C_RED + "Infected" + cls.C_DEFAULT + ": " + cls.C_L_YELLOW + \
                                       anamnesis_element['title'] + cls.C_DEFAULT
                        
                        if self.no_color:
                            file_message = "Infected: " + anamnesis_element['title']
                else:
                    if heuristic_result['result']:
                        if not self.no_color:
                            file_message = cls.C_L_YELLOW + "Suspected" + cls.C_DEFAULT + ": " + \
                                           cls.C_RED + heuristic_result['detected'] + cls.C_DEFAULT + \
                                           " found @ position" + str(heuristic_result['position'])
                        
                        else:
                            file_message = "Suspected: " + heuristic_result['detected'] + " found @ position " + \
                                           str(heuristic_result['position'])
            
            print('[{0:.2f}% | {1!s}kB/s] {2!s} ({3!s})'.format(current_progress, scan_speed, file_item['path'],
                                                                file_message, sep=" ", end="", flush=True))
            
            # print(len(anamnesis_element))
            if len(anamnesis_element) > 0:
                self.anamnesis_list.append(anamnesis_element)
    
    def cure(self):
        """
        Healing function
        
        :return: Void
        """
        
        rpt = report.Report()
        fs = fsys.FileSystem()
        
        for element in self.anamnesis_list:
            cure_result = {
                'path': element['path'],
                'action': element['action'],
                'title': element['title'],
                'result': '',
                'result_message': ''
            }
            
            # Удаление зараженного файла
            if element['action'] == 'delete':
                try:
                    os.remove(element['path'])
                    cure_result['result'] = 'ok'
                except PermissionError as e:
                    cure_result['result'] = 'false'
                    cure_result['result_message'] = e
            
            # Лечение зараженного файла
            if element['action'] == 'cure':
                file_content = fs.get_file_content(element['path'])
                cure_result['result'] = 'cure'
                first_part: bytes = file_content[:element['cure']['start']]
                second_part: bytes = file_content[element['cure']['end']:]
                
                result = fs.put_file_content(element['path'], first_part + second_part)
                cure_result['result'] = 'false'
                if result:
                    cure_result['result'] = 'ok'
            
            if element['action'] == 'quarantine':
                try:
                    os.rename(element['path'], element['path'] + '.suspected')
                except PermissionError as e:
                    cure_result['result'] = 'false'
                    cure_result['result_message'] = e
            
            rpt.append(cure_result)
        
        rpt.write_file()
        rpt.output()


if __name__ == "__main__":
    print("Ready")
    parser = argparse.ArgumentParser(description='Process some integers.')
    parser.register("type", "bool", lambda v: v.lower() == "true")
    parser.add_argument(
        "site",
        default="./",
        nargs="?",
        help="Site folder"
    )
    parser.add_argument(
        "-nc", "--no-color",
        action='store_true',
        help="Disable color output"
    )
    parser.add_argument(
        "-nh", "--no-heuristic",
        action="store_true",
        help="Disable heuristic detection. Check all files"
    )
    parser.add_argument('-v', '--version', action='version', version='%(prog)s 0.0.1')
    
    args = parser.parse_args()
    
    kdsh = TheKadeshi(args)
    kdsh.get_files_list()
    print("Found", len(kdsh.files_list), "files, ~", kdsh.total_files_size, "bytes")
    
    kdsh.load_signatures()
    
    kdsh.scan_files()
    
    kdsh.cure()
