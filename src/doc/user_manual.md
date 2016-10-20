# The Bago software.

**bago** is a tool to draw UML Class Diagrams (Many other UML 2.0 diagrams are
planned, and also Flowchart and Entity-Relationship diagrams).

## Versions and Features

+ v0.3 first public release. Support Class diagrams only.
+ v0.2
+ v0.1 uses a lot of `case` statements. Many node types supported. 


## Requirements to use the tool

+ install [PHP](http://php.net/).
+ install [graphviz](http://www.graphviz.org/).
+ the program expects these two to be in your PATH.
+ This was tested only on GNU+Linux, but it should work also on
other platforms.
+ download  bago.zip wherever you want. You obtain the file `bago_cli.zip`

## How to use it
You  create a text file (for example mydiagram.txt) containing the description
of the
diagram. The valid syntax is described [here](bago_syntax.md). Then, in a
terminal you execute`php bago_cli.php mydiagram.txt`. You get the file `mydiagram.svg`.


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



