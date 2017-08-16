import gettext
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
        :return:
        """
        gettext.bindtextdomain('report', localedir='locale')
        gettext.textdomain('report')
        _ = gettext.gettext

        report_filename = "thekadeshi.report." + datetime.strftime(datetime.now(), "%Y.%m.%d.%H.%M") + ".html"
        report_file: str = os.path.join(report_path, report_filename)

        report_template = self.load_template()

        # Replace languages
        rendered_template = report_template.replace(b'{theKadeshi_scan_report}',
                                                    bytes(_('theKadeshi scan report'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{theKadeshi_report}', bytes(_('theKadeshi report'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Report}', bytes(_('Report'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Website}', bytes(_('Website'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Download}', bytes(_('Download'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Contacts}', bytes(_('Contacts'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Important}', bytes(_('Important!'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Warning_text}', bytes(
            _('Never keep this file at your hosting account. Delete it after your job done.!'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Version}', bytes(_('Version'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Date}', bytes(_('Date'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Total_files_scanned}',
                                                      bytes(_('Total files scanned'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Total_files_size}', bytes(_('Total files size'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{bytes}', bytes(_('bytes'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Malwares_found}', bytes(_('Malwares found'), 'utf-8'))

        rendered_template = rendered_template.replace(b'{Nothing_found}', bytes(_('Nothing is found'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Site_clean}',
                                                      bytes(_('Looks like your site is clean'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Consider}', bytes(_(
            'Please consider to repeat scan with a new version of the scanner. You can download it in our repository'),
                                                                           'utf-8'))

        rendered_template = rendered_template.replace(b'{File}', bytes(_('File'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Infection}', bytes(_('Infection'), 'utf-8'))
        rendered_template = rendered_template.replace(b'{Action}', bytes(_('Action'), 'utf-8'))

        # Replace data
        rendered_template = rendered_template.replace(b'{Result_Json}', bytes(json.dumps(self.report_list), 'utf-8'))
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
