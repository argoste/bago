#!/usr/bin/env python3
import sys, os
from string import Template
arg = sys.argv
instructions = '''Usage:  ./bago.py <input_file> [ <output_file> ]\n
where <input_file> is a valid Bago file (a textual description of a diagram).
'''

digraph_template = Template('digraph {$content}')
node_template = Template('$identifier [shape=ellipse]\n')

if len(arg) < 2 :
    print(instructions)
else:
    input_file = open(arg[1])
    input_text = input_file.read()
    input_file.close()
    output_text = digraph_template.substitute(content = '\n1 \n 2 \n 1 -> 2\n')
    if len(arg) < 3 :
        output_filename = 'output.dot'
    else:
        output_filename = arg[2]
    output_file = open(output_filename, 'w')
    output_file.write(output_text)
    output_file.close()
    os.system('dot ' + output_filename )
    print(output_text)
