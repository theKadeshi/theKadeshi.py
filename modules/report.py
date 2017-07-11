import time
import json
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
            }
        })
        
        # print(self.report_list)
        pass
    
    def write_file(self):
        """
        Temporary function

        :todo: fixme
        :param element:
        :return:
        """
        
        file = open("testfile.json", "w")
        
        file.write(json.dumps(self.report_list))
        
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
