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

## A remainder of PHP regex

PHP has a built-in library called PCRE, for Perl-compatible regular expressions. As Bago is heavily based on this library, I add a summary here of what I use most. Credit goes to [PHP manual](www.php.net).

<blockquote>
A regular expression is a pattern that is matched against a subject string
from left to right. Most characters stand for themselves in a pattern, and
match the corresponding characters in the subject.
</blockquote>

The pattern is enclosed in a couple of delimiters and in single quotes.
Patterns are for example `'~pattern~'`, `'%pattern%'`.

pattern                 | what it does
------------------------|--------------------------------------
`{x}`                   | exactly `x` times (it is a quantifier)
`{x,y}`                 | at least `x`, at most `y`
`{x,}`                  | at least `x` times
`*`                     | equivalent to `{0,}`
`+`                     | equivalent to `{1,}`
`?`                     | equivalent to {0,1}, also subpattern modifier
`.`  | any character except newline, in default mode
`[`                     | start class definition
`]`                     | end class definition
 &#124;                    | separates alternatives
`(subpattern)`          | captured group
`(?:subpattern:)`       | non-captured group
`(?P<name>subpattern)`  | named group
`\` | general escape character
`\A` | always start of the subject
`^` | if mode is default, start of subject, if mode is multiline, start of line
`$` | if mode is default, end of subject
`\n` | newline, aka `ASCII 0x0A`
`\r` | carriage return `ASCII 0x0D`
`\t` | horizontal tabulation `ASCII 0x09`
`\xHH` | character with hex code HH
`\d` | any decimal digit
`\D` | not a decimal digit
`\h` | any horizontal whitespace character
`\H` | 
`\s` | any whitespace character
`w`  | any Perl word charater

`\S` is the complementary set of `\s` TODO reformulate
inside square brackets the only meta-characters are `\` `^` `-`

Modifiers

multiline `m`: when this modifier is set `\A` matches a

