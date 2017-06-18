#!/usr/bin/env python
import argparse
import modules.thekadeshi as the_kadeshi

if __name__ == "__main__":
    print("Ready")
    parser = argparse.ArgumentParser(description='Process some integers.')
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
        help="Disable color output"
    )
    parser.add_argument(
        "-nh", "--no-heuristic",
        action="store_true",
        help="Disable heuristic detection. Check all files"
    )
    parser.add_argument('-v', '--version', action='version', version='%(prog)s 0.0.1')
    
    args = parser.parse_args()
    
    kdsh = the_kadeshi.TheKadeshi(args)
    kdsh.get_files_list()
    print("Found", len(kdsh.files_list), "files, ~", kdsh.total_files_size, "bytes")
    
    kdsh.load_signatures()
    
    kdsh.scan_files()
    
    kdsh.cure()
