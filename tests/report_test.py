import unittest
import modules.report as rpt


class TestReportsMethods(unittest.TestCase):
    def test_load_template(self):
        report = rpt.Report()
        page_content = report.load_template()

        self.assertTrue(len(page_content) > 100)
