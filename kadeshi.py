#!/usr/bin/env python3.6
"""
Main module
"""
import argparse
import modules.thekadeshi as kadeshi
from _version import __version__

if __name__ == "__main__":
    PARSER = argparse.ArgumentParser(description='There is the options.')
    PARSER.register("type", "bool", lambda v: v.lower() == "true")

    PARSER.add_argument(
        "site",
        default="./",
        nargs="?",
        help="Site folder"
    )

    PARSER.add_argument(
        "-nc", "--no-color",
        action='store_true',
        help="Disables color output. Enabled by default"
    )

    PARSER.add_argument(
        "-dc", "--no-cure",
        action="store_true",
        help="Disables malware cleanup. Enabled by default"
    )

    PARSER.add_argument(
        "-nr", "--no-report",
        action="store_true",
        help="Disables report file. Enabled by default"
    )

    PARSER.add_argument(
        "-d", "--debug",
        action="count",
        default=0,
        help="Enables debug mode. Disabled by default"
    )

    PARSER.add_argument(
        "-e", "--export",
        action="count",
        default=0,
        help="Exports signature into JSON format"
    )

    PARSER.add_argument('-v', '--version', action='version', version='%(prog)s ' + __version__)

    ARGS = PARSER.parse_args()

    KDSH = kadeshi.TheKadeshi(ARGS)

    print("theKadeshi version", __version__)

    KDSH.load_signatures()

    print('Loaded', (int(len(KDSH.signatures_database['r'])) +
                     int(len(KDSH.signatures_database['h']))), 'signatures')

    if ARGS.export > 0:
        print('Export mode')
        KDSH.export()
        exit()

    KDSH.get_files_list()

    print('Found', len(KDSH.files_list), 'files, ~', KDSH.total_files_size, 'bytes')

    KDSH.scan_files()

    KDSH.cure()
