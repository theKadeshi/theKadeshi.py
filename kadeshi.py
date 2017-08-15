#!/usr/bin/env python3.6
"""
Main module
"""
import gettext
import locale
import argparse
import os

import modules.thekadeshi as kadeshi
from _version import __version__

if __name__ == "__main__":
    locale.setlocale(locale.LC_ALL, '')

    os.environ["LANGUAGE"] = locale.getdefaultlocale()[0][:2]

    gettext.bindtextdomain('main', localedir='locale')
    gettext.textdomain('main')
    _ = gettext.gettext

    PARSER = argparse.ArgumentParser(description=_('There is the options'))
    PARSER.register("type", "bool", lambda v: v.lower() == "true")

    PARSER.add_argument(
        "site",
        default="./",
        nargs="?",
        help=_("Site folder")
    )

    PARSER.add_argument(
        "-nc", "--no-color",
        action='store_true',
        help=_("Disables color output. Enabled by default")
    )

    PARSER.add_argument(
        "-dc", "--no-cure",
        action="store_true",
        help=_("Disables malware cleanup. Enabled by default")
    )

    PARSER.add_argument(
        "-nr", "--no-report",
        action="store_true",
        help=_("Disables report file. Enabled by default")
    )

    PARSER.add_argument(
        "-d", "--debug",
        action="count",
        default=0,
        help=_("Enables debug mode. Disabled by default")
    )

    PARSER.add_argument(
        "-e", "--export",
        action="count",
        default=0,
        help=_("Exports signatures into JSON format")
    )

    PARSER.add_argument(
        "--language",
        choices=('en', 'ru'),
        type=str,
        help=_("Changes program's language")
    )

    ARGS = PARSER.parse_args()

    if ARGS.language is not None and len(ARGS.language) == 2:
        os.environ["LANGUAGE"] = ARGS.language

    KDSH = kadeshi.TheKadeshi(ARGS)

    print(_("theKadeshi version %s") % __version__)

    KDSH.load_signatures()

    print(_('Loaded %s signatures') % str(int(len(KDSH.signatures_database['r'])) +
                                          int(len(KDSH.signatures_database['h']))))

    if ARGS.export > 0:
        print(_('Export mode'))
        KDSH.export()
        exit()

    KDSH.get_files_list()

    print(_('Found %s files, ~ %s bytes') % (len(KDSH.files_list), KDSH.total_files_size))

    KDSH.scan_files()

    KDSH.cure()
