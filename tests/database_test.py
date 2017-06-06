import unittest
import modules.database as dbase


class TestCMSMethods(unittest.TestCase):
	def test_get_hash_signatures(self):
		dbase.get_hash_signatures()
		self.assertTrue(True)
