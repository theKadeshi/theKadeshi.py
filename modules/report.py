import time
import json
import os

import sys
from datetime import datetime

import modules.colors as cls


class Report:
    """
    Report class
    """
    
    report_list = []
    
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
        report_filename = "thekadeshi.report." + datetime.strftime(datetime.now(), "%Y.%m.%d.%H.%M") + ".html"
        report_file = os.path.join(report_path, report_filename)
        
        file = open(report_file, "w")
        
        report_template = self.load_template()
        
        rendered_template = report_template.replace('{Result_Json}', json.dumps(self.report_list))
        
        file.write(rendered_template)
        
        file.close()
        
        # print(json.dumps(self.report_list))
    
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
                action_color = cls.C_MAGENTA
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
        if getattr(sys, 'frozen', False):
            current_folder = os.path.dirname(sys.executable)
            template_path = 'report.html'
        else:
            current_folder = os.path.dirname(__file__)
            template_path = '../files/report.html'
        
        total_path = os.path.join(current_folder, template_path)
        
        with open(total_path, "r") as report_template:
            data = report_template.read()
        
        return data
