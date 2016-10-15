# The Bago software.
**bago** is a tool to draw UML Class Diagrams (Many other UML 2.0 diagrams are
planned, and also Flowchart and Entity-Relationship diagrams). You describe
your diagrams with a simple, semantic, not style-oriented, language. The tool
Then you draws the actual diagram.

## Abstract

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

## the bago language

A bago file has extension `*.bago`

A bago file contains the declaration of UML elements.

A valid bago file content is described using Extended Backus-Naur Form. The
definition symbol is `:=`, a rule end with a semicolon, square brackets enclose
optional parts.


I simplified things for me: ID are only made of numbers, letters and
underscore.

~~~
diagram := statement_list;

statement_list := statement, [statement_list];

statement := class_statement | object_statement | comment_statement |
        actor_statement | usecase_statement | relationship_statement ;

relationship statement := association_statement  | generalization_statement |
    aggregation_statement | composition_statement | instantiation_statement ;

class_statement := 'class', ID , ['{', [property*], [method*], '}' ] ;
property := [ownership], identifier, [':', type], ['=' default_value] ;
method := [ownership], identifier, '()' ;
~~~

Another way of seeing it, more low-level.

~~~
statement := node_statement | edge_statement ;
node_statement := [space | tab], node_keyword, space*, ID, "{", body,"}" ;

identifier := ( number | letter | underscore )* ;

(* If node_keyword is 'class' or 'object', then body is in a special format to
denote properties and methods *)

space := " "; (* Ascii 0x20 *)
tab := "	"; (* Ascii 0x09 *)
~~~

TODO: delete any reference to nodes, the user don't need to be bored, it is
alredy bored trying to understand UML.

## Implementation

Any text editor can be used to write bago files. For your convenience I will
try to provide Geany or Komodo Edit syntax highlight and autocompletions.

The core is a php script that translates the bago file to a Graphviz script.
Then the latter is compiled by the dot executable (the original C version or
the ecmascript viz.js) into a diagram.

### CLI

You run a script (`php bago_cli.php mydiagram.bago`) and it will create a file called mydiagram.gv

Then you can view the created diagram with [xdot](https://github.com/jrfonseca/xdot.py)
or create the diagram from command line using the original [dot](http://www.graphviz.org) with `dot `
## about the name
I've checked the name **bago** here [](http://usersthink.com/startup-names/) and the file extension here [](http://filext.com/). The name has no real meaning, but it is inpired to _bagolaro_, the Italian name for _Celtis australis_, a tree of the Mediterranean basin.
