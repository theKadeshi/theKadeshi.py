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

    def test_write_signature_statistic(self):
        db = dbase.Database()
        signatures = db.get_regexp_signatures()
        signatures_length = len(signatures)
        self.assertTrue(signatures_length > 0)

        single_signature = signatures[1]

        print(single_signature)

        db.write_statistic(single_signature)
