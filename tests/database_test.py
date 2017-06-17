import unittest
import modules.database as dbase


class TestDatabaseMethods(unittest.TestCase):
    """
    Database tests
    """
    
    def test_get_hash_signatures(self):
        """
        Test of reading hash signatures
        :return:
        """
        
        db = dbase.Database()
        db.get_hash_signatures()
        self.assertTrue(True)
