"""
Module theKadesi
"""
import base64
import os
import hashlib
import time
import re
import json
import modules.database as dbase
import modules.report as report
import modules.colors as cls
import modules.filesystem as f_system


class TheKadeshi:
    """
    Основной класс
    """

    # List of active extensions
    permitted_extensions = (".php", ".js", ".htm", ".html", "pl", "py", "suspected", "ico")

    # List of infected files
    anamnesis_list: list = []

    # List of files
    files_list: list = []

    # Total files size in bytes
    total_files_size: int = 0

    # База сигнатур
    signatures_database = {'h': [], 'r': []}

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

        for root, _, files in os.walk(self.site_folder):
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

        database = dbase.Database()
        self.signatures_database['h'] = database.get_hash_signatures()
        self.signatures_database['r'] = database.get_regexp_signatures()

    def scan_files(self):
        """
        Функция сканирования файлов

        :return: Ничего
        """

        def check_signature_correctness(file_size: int):
            """
            Check signature size correctness

            :type signature: object
            :param signature: Signature element
            :param file_size: File size in bytes
            :return:
            :rtype bool
            """
            signature_correctness_flag: bool = True

            if signature['min_size'] is not None and signature['max_size'] is not None:
                if signature['min_size'] > file_size > signature['max_size']:
                    signature_correctness_flag = False
            else:
                if signature['min_size'] is not None:
                    if file_size < signature['min_size']:
                        signature_correctness_flag = False

                if signature['max_size'] is not None:
                    if file_size > signature['max_size']:
                        signature_correctness_flag = False

            return signature_correctness_flag

        # Таймер
        timer_start: float = time.time()

        # Сколько просканировано в байтах, необходимо для вычисления скорости
        total_scanned: int = 0

        # Расчетная скорость сканирования
        scan_speed: float = 0

        # Счетчик проверенных файлов
        scanner_counter: int = 0

        signatures_statistic = {}

        file_system = f_system.FileSystem()

        local_hash_signatures = self.signatures_database['h']
        local_regex_signatures = self.signatures_database['r']

        # Берем файл из списка
        local_files_list = self.files_list
        for file_item in local_files_list:
            anamnesis_element: list = []
            current_progress = (total_scanned + file_item['size']) * 100 / self.total_files_size

            is_file_clean: bool = True

            is_file_error: bool = False

            # Флаг, нужно ли продолжать сканирование
            need_to_scan: bool = True

            content = file_system.get_file_content(file_item['path'])

            # Если нет ошибок чтения, то сканируем
            content_length: int = len(content)
            if content_length == 0:
                break

            # Хеш сумма файла
            file_hash: str = hashlib.sha256(content).hexdigest()

            # local_signatures = self.signatures_database['h']
            for signature in local_hash_signatures:

                if file_hash == signature['expression']:

                    is_file_clean = False

                    anamnesis_element = {
                        'id': signature['id'],
                        'type': 'h',
                        'path': file_item['path'],
                        'size': file_item['size'],
                        'title': signature['title'],
                        'action': signature['action']
                    }

                    if signature['action'] == 'delete':
                        need_to_scan = False

                    # Прерываем цикл
                    break

            if need_to_scan:

                # Если сканирование по хэш ничего не выявило, то ищем по сигнатурам
                try:
                    string_content = content.decode('utf-8')
                except UnicodeDecodeError:
                    string_content = content.decode('latin-1')

                for signature in local_regex_signatures:

                    is_signature_correct = check_signature_correctness(file_item['size'])

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
                            signatures_statistic[signature['id']] = old_value + \
                                                                    signatures_time_delta

                        if matches is not None:
                            is_file_clean = False
                            start_position: int = matches.span()[0]
                            end_position: int = matches.span()[1]

                            anamnesis_element = {
                                'id': signature['id'],
                                'type': 'r',
                                'path': file_item['path'],
                                'size': file_item['size'],
                                'title': signature['title'],
                                'action': signature['action'],
                                'cure': {'start': start_position,
                                         'end': end_position,
                                         'length': end_position - start_position}
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
                if not is_file_clean:
                    file_message = cls.C_RED + "Infected" + \
                                   cls.C_DEFAULT + ": " + \
                                   cls.C_L_YELLOW + anamnesis_element['title'] + \
                                   cls.C_DEFAULT

                    if self.no_color:
                        file_message = "Infected: " + anamnesis_element['title']

            short_file_path: str = file_item['path'][len(self.site_folder)::]
            print('[{0:.2f}% | {1:.1f}kB/s] {2!s} ({3!s})'.format(current_progress,
                                                                  scan_speed,
                                                                  short_file_path,
                                                                  file_message,
                                                                  sep=" ",
                                                                  end="",
                                                                  flush=True))

            # print(len(anamnesis_element))
            anamnesis_length = len(anamnesis_element)
            if anamnesis_length > 0:
                self.anamnesis_list.append(anamnesis_element)

        if self.debug_mode:
            a1_sorted_keys = sorted(signatures_statistic,
                                    key=signatures_statistic.get,
                                    reverse=False)
            for array_element in a1_sorted_keys:
                print(array_element, signatures_statistic[array_element])

    def cure(self):
        """
        Healing function

        :return: Void
        """

        rpt = report.Report()
        fs = f_system.FileSystem()

        for element in self.anamnesis_list:

            cure_result = {
                'signature_id': element['id'],
                'path': element['path'],
                'size': element['size'],
                'action': element['action'],
                'title': element['title'],
                'type': element['type'],
                'result': '',
                'result_message': '',
                'position': '',
                'cure': {'start': 0, 'end': 0, 'length': 0, 'sample': ''}
            }

            # Удаление зараженного файла
            if self.no_cure:
                cure_result['result'] = 'disabled'
            else:
                if element['action'] == 'delete':
                    try:
                        os.remove(element['path'])
                        cure_result['result'] = 'ok'
                    except PermissionError as e:
                        cure_result['result'] = 'false'
                        cure_result['result_message'] = e

                    if 'cure' in element and 'length' in element['cure']:
                        cure_result['cure']['length'] = element['cure']['length']

                # Лечение зараженного файла
                elif element['action'] == 'cure':
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

                else:  # element['action'] == 'quarantine':
                    try:
                        os.rename(element['path'], element['path'] + '.suspected')
                    except PermissionError as e:
                        cure_result['result'] = 'false'
                        cure_result['result_message'] = e

            rpt.append(cure_result)
            self.write_statistic(cure_result)
            # dbase.Database.write_statistic(cure_result)

        rpt.total_files_size = self.total_files_size
        rpt.total_files_count = len(self.files_list)

        if not self.no_report:
            rpt.write_file(self.site_folder)
        rpt.output()

    @staticmethod
    def export():
        """
        Exports signatures
        :return:
        """
        database = dbase.Database()
        raw_signatures = {'r': database.get_raw_regexp_signatures(),
                          'h': database.get_hash_signatures()}
        json_data = json.dumps(raw_signatures)
        file_system = f_system.FileSystem()

        file_system.put_file_content('signatures.json', bytes(json_data, 'utf-8'))
        print('Export complete')

    @staticmethod
    def write_statistic(cure_result):
        """
        Save statistics data

        :param cure_result:
        :return:
        """
        database = dbase.Database()

        database.write_statistic(cure_result)
