import base64
import os
import hashlib
import time
import re
import modules.database as dbase
import modules.report as report
import modules.colors as cls
import modules.filesystem as fsys


# import modules.heuristic as h_mod


class TheKadeshi:
    """
    Основной класс
    """
    
    # Список расширений, которые будут сканироваться
    permitted_extensions = (".php", ".js", ".htm", ".html", "pl", "py", "suspected", "ico")
    
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
    
    def __init__(self, arguments):
        """
        Scanner initialization

        :param arguments: Scanner arguments
        :type arguments: object{}
        """
        
        self.site_folder: str = arguments.site
        self.no_color: bool = arguments.no_color
        self.no_cure: bool = arguments.no_cure
        self.no_report: bool = arguments.no_report
        self.debug_mode: bool = (arguments.debug == 1)
    
    def get_files_list(self):
        """
        Функция получения списка файлов

        :return: Ничего, просто заполняет список файлов
        """
        
        for root, dirs, files in os.walk(self.site_folder):
            for name in files:
                if name.endswith(self.permitted_extensions):
                    file_path: str = os.path.join(root, name)
                    file_size: int = os.path.getsize(file_path)
                    
                    # No need to scan empty files
                    if file_size > 10:
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
        
        signatures_statistic = {}
        
        # heuristic = h_mod.Heuristic()
        
        # Берем файл из списка
        local_files_list = self.files_list
        for file_item in local_files_list:
            anamnesis_element: list = []
            current_progress = (total_scanned + file_item['size']) * 100 / self.total_files_size
            
            is_file_clean: bool = True
            
            is_file_error: bool = False
            
            # Флаг, нужно ли продолжать сканирование
            need_to_scan: bool = True
            
            # heuristic_result: h_mod.IHeuristicCheckResult = h_mod.IHeuristicCheckResult()
            
            with open(file_item['path'], mode='rb') as f:
                
                # Тут у нас обработчик ошибок.
                try:
                    content = f.read()
                    f.close()
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
                    
                    local_signatures = self.signatures_database['h']
                    for signature in local_signatures:
                        
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
            
            if need_to_scan and self.database_present:
                
                # Если сканирование по хэш ничего не выявило, то ищем по сигнатурам
                try:
                    string_content = content.decode('utf-8')
                except UnicodeDecodeError:
                    string_content = content.decode('latin-1')
                
                local_signatures = self.signatures_database['r']
                for signature in local_signatures:
                    is_signature_correct = True
                    if signature['min_size'] is not None:
                        if file_item['size'] < signature['min_size']:
                            is_signature_correct = False
                    
                    if signature['max_size'] is not None:
                        if file_item['size'] > signature['max_size']:
                            is_signature_correct = False
                    
                    if signature['min_size'] is not None and signature['max_size'] is not None:
                        if signature['min_size'] > file_item['size'] > signature['max_size']:
                            is_signature_correct = False
                    
                    if is_signature_correct:
                        signature_time_start = time.time()
                        # print("now shall scan:", signature['id'])
                        matches = re.search(signature['expression'], string_content)
                        signature_time_end = time.time()
                        
                        if self.debug_mode:
                            signatures_time_delta = signature_time_end - signature_time_start
                            if not signature['id'] in signatures_statistic:
                                signatures_statistic[signature['id']] = 0
                            old_value = signatures_statistic[signature['id']]
                            signatures_statistic[signature['id']] = old_value + signatures_time_delta
                        
                        if matches is not None:
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
            
            total_scanned = total_scanned + file_item['size']
            current_time = time.time()
            time_delta = current_time - timer_start
            if time_delta != 0:
                scan_speed = total_scanned / time_delta / 1024
            scanner_counter = scanner_counter + 1
            
            file_message: str = ''.join(cls.C_GREEN + "Clean" + cls.C_DEFAULT)
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
            
            short_file_path: str = file_item['path'][len(self.site_folder)::]
            print('[{0:.2f}% | {1:.1f}kB/s] {2!s} ({3!s})'.format(current_progress, scan_speed, short_file_path,
                                                                  file_message, sep=" ", end="", flush=True))
            
            # print(len(anamnesis_element))
            if len(anamnesis_element) > 0:
                self.anamnesis_list.append(anamnesis_element)
        
        if self.debug_mode:
            a1_sorted_keys = sorted(signatures_statistic, key=signatures_statistic.get, reverse=False)
            for r in a1_sorted_keys:
                print(r, signatures_statistic[r])
                # print(signatures_statistic)
    
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
                'type': element['type'],
                'result': '',
                'result_message': '',
                'position': '',
                'cure': {'start': 0, 'end': 0, 'length': 0, 'sample': ''}
            }
            
            # Удаление зараженного файла
            if element['action'] == 'delete':
                try:
                    if not self.no_cure:
                        os.remove(element['path'])
                        cure_result['result'] = 'ok'
                    else:
                        cure_result['result'] = 'disabled'
                except PermissionError as e:
                    cure_result['result'] = 'false'
                    cure_result['result_message'] = e
            
            # Лечение зараженного файла
            if element['action'] == 'cure':
                if not self.no_cure:
                    file_content = fs.get_file_content(element['path'])
                    cure_result['result'] = 'cure'
                    
                    slice_start: int = element['cure']['start']
                    slice_end: int = element['cure']['end']
                    
                    first_part: bytes = file_content[:slice_start]
                    second_part: bytes = file_content[slice_end:]
                    
                    # Sample code start position
                    sample_start: int = 0
                    if slice_start > 30:
                        sample_start = slice_start - 30
                    cure_result['cure']['start'] = slice_start
                    cure_result['cure']['end'] = slice_end
                    cure_result['cure']['length'] = slice_end - slice_start
                    
                    sample_slice = file_content[sample_start: slice_start + 120]
                    cure_result['cure']['sample'] = str(base64.b64encode(sample_slice), 'ascii')
                    result = fs.put_file_content(element['path'], first_part + second_part)
                    cure_result['result'] = 'false'
                    if result:
                        cure_result['result'] = 'ok'
                else:
                    cure_result['result'] = 'disabled'
            
            if element['action'] == 'quarantine':
                if not self.no_cure:
                    try:
                        os.rename(element['path'], element['path'] + '.suspected')
                    except PermissionError as e:
                        cure_result['result'] = 'false'
                        cure_result['result_message'] = e
                else:
                    cure_result['result'] = 'disabled'
            
            rpt.append(cure_result)
        
        if not self.no_report:
            rpt.write_file(self.site_folder)
        rpt.output()
