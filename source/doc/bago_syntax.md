## the bago language

A bago file describe a diagram in a semantic way, i.e. the logical structure,
not the presentation. A bago file is plain text and has extension `*.bago`

In the following I describe the bago language using Extended Backus-Naur Form
as in EBNF is defined by ISO/IEC 14977 : 1996(E).

### EBNF in brief

Every syntactic term is explained by a rule. Every rule is terminated by a
period `.`. A sequence is made of syntactic terms, concatenated by commas `,`.
Optional parts are between `(/` and `/)`. Parts that can
be repeated (zero or more times) are between`(:` and `:)`. Terminals, i.e.
parts to be inserted verbatim, are enclosed in single o double quotes.


## Class Diagrams

~~~

diagram = (: class_statement | relationship_statement  :) .

class_statement = "@class", identifier, (/ "{", (/ property_list /), (/ method_list /), "}" /) .

identifier = (: number | letter | underscore :) .

property_list = (: property_statement, ',' :) .

property_statement = identifier.

method_list = (: method, ",":) .

method = identifier, '()' .

relationship statement = generalization_statement |
    aggregation_statement | composition_statement |  association_statement .

generalization_statement = identifier, "@extend", identifier .

composition_statement = identifier, "@partof" identifier .

aggregation_statement = identifier, "@sharedby", identifier .

association_statement = identifier (/, multiplicity /) ,  @assoc (/, association_name/), identifier (/ , multiplicity /) .

association_name = "{", (?a string of characters?), "}" .

~~~

