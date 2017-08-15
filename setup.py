"""
cx_Freeze setup
"""
import re
from cx_Freeze import setup, Executable

VERSION_FILE: str = "_version.py"
VERSION_STRING = open(VERSION_FILE, "rt").read()
VERSION_REGEX = r"^__version__ = ['\"]([^'\"]*)['\"]"
VERSION_MATCHES = re.search(VERSION_REGEX, VERSION_STRING, re.M)
if VERSION_MATCHES:
    version_string: str = VERSION_MATCHES.group(1)
else:
    raise RuntimeError("Unable to find version string in %s." % (VERSION_FILE,))

BUILD_OPTIONS = dict(packages=[],
                     include_files=['./database/thekadeshi.db', 'files/report.html'], )

setup(
    name='theKadeshi',
    version=version_string,
    url='https://thekadeshi.com',
    license='MIT',
    author='theKadeshi',
    author_email='info@thekadeshi.com',
    description='Antivirus for your site',
    options=dict(build_exe=BUILD_OPTIONS),
    executables=[Executable(script="kadeshi.py", icon="icon.ico")]
)
