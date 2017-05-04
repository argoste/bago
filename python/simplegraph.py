from graphviz import Digraph

mydig = Digraph(comment='An example digraph')
mydig.node('A', 'King Arthur')
mydig.node('B', 'Ginevra')
mydig.edges(['AB'])
mydig.render('simple.gv', view=True)
