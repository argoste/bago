# Developer Manual

## Why another tool?

Diagrams are very useful in software development for team communication,
specification, design and documentation.

For simple ideas it makes sense to sketch on paper or whiteboard. But drawing
with computer allow to keep diagrams in the same location of the sources.

Some UML drawing tools are based on direct manipulation. Other use a textual
description of the diagram. Text-based tools can be beneficial for many reason.

+ The developer uses his/her favourite text editor, and don't have to switch to
another tool to do diagrams. + Version Control friendly. + You don't have to
sopend time rearranging your diagram, the tool does it.

There are many tools like this. There is Plantuml, UMLGraph, Mermaid. Why make
another? Because I want a language that describes the semantics of the
graphical language (UML) in a clear way, leaving to layout tool (Graphviz) the
burden to actually draw it.

I prefer a language unambiguos and easy to remember (ideally you should read
the manual only once) than easy to type (mermaid and plantuml use simbols like
parenthesis, colon for their syntax, I prefer tags because they can be self
explanatory).

The ultimate goal is to have a responsive (no java) tool to draw diagrams, as
standalone or embedded in MarkDown documents (á la Mermaid). The language try
to be as similar as possible to the good UMLGraph by [Diomidis
Spinellis](http://www.spinellis.gr).

Keep in mind that bago knows nothing about modelling, it does not understand
your diagram. You are in charge for making the model meaningful and truthful. 



## Contributing

If you want to know how this work, or maybe contribute.

A diagram can be seen as a pictorial representation  of a [ graph in discrete mathemathics](https://en.wikipedia.org/wiki/Graph_(discrete_mathematics)). See also [graph drawing](https://en.wikipedia.org/wiki/Graph_drawing).

The digraph is drawn using [graphviz]().


Another way of seeing it, more low-level.

~~~
statement = node_statement | edge_statement .
node_statement = (/ space | tab /), node_keyword, space*, ID, "{", body,"}" .

identifier = (: number | letter | underscore :) .

(* If node_keyword is 'class' or 'object', then body is in a special format to
denote properties and methods *)

space = " ". (* Ascii 0x20 *)
tab = "	". (* Ascii 0x09 *)


~~~