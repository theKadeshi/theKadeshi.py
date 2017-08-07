from cx_Freeze import setup, Executable

import re

version_file = "_version.py"
verstrline = open(version_file, "rt").read()
VSRE = r"^__version__ = ['\"]([^'\"]*)['\"]"
mo = re.search(VSRE, verstrline, re.M)
if mo:
    version_string: str = mo.group(1)
else:
    raise RuntimeError("Unable to find version string in %s." % (version_file,))

buildOptions = dict(packages=[],
                    include_files=['./database/thekadeshi.db', 'files/report.html']
                    )

setup(
    name='theKadeshi',
    version=version_string,
    url='https://thekadeshi.com',
    license='MIT',
    author='theKadeshi',
    author_email='info@thekadeshi.com',
    description='Antivirus for your site',
    options=dict(build_exe=buildOptions),
    executables=[Executable(script="kadeshi.py", icon="icon.ico")]
)
