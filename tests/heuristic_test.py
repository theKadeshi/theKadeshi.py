import unittest
import modules.heuristic as heuristic


class TestHeuristicMethods(unittest.TestCase):
    def test_get_hash_signatures(self):
        h = heuristic.Heuristic()
        result = h.sigmoid(1)
        print(result)
        self.assertEqual(result, 0.7310585786300049, "Sigmoid function invalid")
