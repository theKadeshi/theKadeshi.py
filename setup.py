from cx_Freeze import setup, Executable

buildOptions = dict(packages=[],
                    include_files=['./database/thekadeshi.db', 'files/report.html']
                    )

setup(
    name='theKadeshi',
    version='0.1.11',
    url='https://thekadeshi.com',
    license='MIT',
    author='theKadeshi',
    author_email='info@thekadeshi.com',
    description='Antimalware for your site',
    options=dict(build_exe=buildOptions),
    executables=[Executable(script="kadeshi.py", icon="icon.ico")]
)
