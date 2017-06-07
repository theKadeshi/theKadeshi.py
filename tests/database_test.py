import unittest
import modules.database as dbase


class TestDatabaseMethods(unittest.TestCase):
    def test_get_hash_signatures(self):
        db = dbase.Database()
        db.get_hash_signatures()
        self.assertTrue(True)
