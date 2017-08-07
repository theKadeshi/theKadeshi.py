#!/usr/bin/env python
import argparse
import modules.thekadeshi as the_kadeshi
from _version import __version__

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='There is the options.')
    parser.register("type", "bool", lambda v: v.lower() == "true")
    parser.add_argument(
        "site",
        default="./",
        nargs="?",
        help="Site folder"
    )
    parser.add_argument(
        "-nc", "--no-color",
        action='store_true',
        help="Disables color output. Enabled by default"
    )
    parser.add_argument(
        "-dc", "--no-cure",
        action="store_true",
        help="Disables malware cleanup. Enabled by default"
    )
    parser.add_argument(
        "-nr", "--no-report",
        action="store_true",
        help="Disables report file. Enabled by default"
    )
    parser.add_argument(
        "-d", "--debug",
        action="count",
        default=0,
        help="Enables debug mode. Disabled by default"
    )
    parser.add_argument('-v', '--version', action='version', version='%(prog)s ' + __version__)
    
    args = parser.parse_args()
    
    kdsh = the_kadeshi.TheKadeshi(args)

    print("theKadeshi version", __version__)
    
    kdsh.get_files_list()
    
    print('Found', len(kdsh.files_list), 'files, ~', kdsh.total_files_size, 'bytes')
    
    kdsh.load_signatures()
    
    print('Loaded', (int(len(kdsh.signatures_database['r'])) + int(len(kdsh.signatures_database['h']))), 'signatures')
    
    kdsh.scan_files()
    
    kdsh.cure()
