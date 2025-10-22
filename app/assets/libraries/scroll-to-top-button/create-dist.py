"""
Create-dist
Generates compiled files to dist/

@licence MIT
@author Pablo Pizarro @ppizarror.com
"""

"""
Genenerates a compiled file
"""
def generate_file(main, files):
    w = open(main, 'w')
    for i in files:
        f = open(i, 'r')
        for j in f:
            w.write(j)
        f.close()
    w.close()

# Main files
CSS_FILE = 'dist/jquery-backToTop.min.css'
JS_FILE = 'dist/jquery-backToTop.min.js'

# Project files to add
CSS = ['main.min.css', 'themes.min.css', 'effects.min.css']
JS = ['jquery-backToTop.min.js']

# Generate compiled files
generate_file(CSS_FILE, CSS)
generate_file(JS_FILE, JS)
