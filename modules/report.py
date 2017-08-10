import time
import json
import os
import sys
import modules.filesystem as f_system
import modules.colors as cls
from datetime import datetime
from _version import __version__


class Report:
    """
    Report class
    """
    
    report_list = []
    
    total_files_size: int = 0
    
    total_files_count: int = 0
    
    def append(self, element):
        """
        Temporary function
        
        :todo: fixme
        :param element:
        :return:
        """
        
        self.report_list.append({
            'path': element['path'],
            'time': time.strftime("%Y-%m-%d %H:%M:%S"),
            'title': element['title'],
            'action': element['action'],
            'result': {
                'value': element['result'],
                'message': str(element['result_message'])
            },
            'cure': {
                'start': element['cure']['start'],
                'end': element['cure']['end'],
                'length': element['cure']['length'],
                'sample': element['cure']['sample'],
            }
        })
    
    def write_file(self, report_path):
        """
        Temporary function

        :param report_path:
        :todo: fixme
        :param element:
        :return:
        """
        report_filename: str = "thekadeshi.report." + datetime.strftime(datetime.now(), "%Y.%m.%d.%H.%M") + ".html"
        report_file: str = os.path.join(report_path, report_filename)
        
        report_template = self.load_template()
        
        rendered_template = report_template.replace(b'{Result_Json}', bytes(json.dumps(self.report_list), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Application_Version}', bytes(__version__, 'utf-8'))
        rendered_template = rendered_template.replace(b'{Result_Total_Files_Size}',
                                                      bytes(str(self.total_files_size), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Result_Total_Files_Count}',
                                                      bytes(str(self.total_files_count), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Result_Scan_Date}',
                                                      bytes(datetime.strftime(datetime.now(), "%Y-%m-%d %H:%M"),
                                                            'utf-8'))
        fs = f_system.FileSystem()
        
        fs.put_file_content(report_file, bytes(rendered_template))
    
    def output(self):
        """
        Temporary function

        :todo: fixme
        :param element:
        :return:
        """
        
        for elem in self.report_list:
            action_color = cls.C_GREEN
            error_string = ""
            if elem['action'] == 'delete':
                action_color = cls.C_BLUE
            if elem['result']['value'] == 'false':
                error_string = 'Error'
            
            print(cls.C_DEFAULT + '{0!s} {1!s} ({2!s}) {3!s}'.format(
                cls.C_DEFAULT + elem['path'],
                cls.C_L_YELLOW + elem['title'] + cls.C_DEFAULT,
                action_color + elem['action'] + cls.C_DEFAULT,
                cls.C_RED + error_string + cls.C_DEFAULT
            ))
    
    @staticmethod
    def load_template():
        """
        Функция загрузки шаблона отчета
        
        :return:
        """
        if getattr(sys, 'frozen', False):
            current_folder = os.path.dirname(sys.executable)
            template_path = 'report.html'
        else:
            current_folder = os.path.dirname(__file__)
            template_path = '../files/report.html'
        
        fs = f_system.FileSystem()
        
        total_path = os.path.join(current_folder, template_path)
        
        data = fs.get_file_content(total_path)
        
        return data
