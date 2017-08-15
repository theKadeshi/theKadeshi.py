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

        anamnesis_element = {
            'signature_id': single_signature['id'],
            'path': '/some/path/script.php',
            'size': 1234,
            'action': 'cure',
            'title': 'KDSH.PHP.Some.Signature',
            'type': 'php',
            'result': 'cure',
            'result_message': '',
            'position': '',
            'cure': {'start': 1, 'end': 7, 'length': 6, 'sample': ''}
        }

        print(anamnesis_element)

        db.write_statistic(anamnesis_element)
