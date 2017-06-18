from cx_Freeze import setup, Executable

buildOptions = dict(packages=[],
                    include_files=['./database/thekadeshi.db'])

setup(
    name='theKadeshi',
    version='0.0.1',
    # packages=[''],
    # package_dir={'': 'modules', 'database': 'database'},
    url='http://thekadeshi.com',
    license='MIT',
    author='theKadeshi',
    author_email='info@thekadeshi.com',
    description='Antimalware for your site',
    # data_files=[('database', ['database\\thekadeshi.db'])],
    # include_files=['./database/'],
    # requires=['cx_Freeze'],
    options=dict(build_exe=buildOptions),
    executables=[Executable("main.py")]
)
