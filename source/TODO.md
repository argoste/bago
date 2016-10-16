Add detailed instruction for GNU/Linux.
Add detailed instructions for MS.
Add detailed instructions for Apple.
install Qemu/kvm
add syntax highlight for at least one editor.

LICENSE or CREDITS
add docstrings (or whatever are them called) to functions

I simplified things for me: ID are only made of numbers, letters and
underscore.


TODO add instantiation_statement
TODO add note_statement to class diagrams. This is tricky: I want a node with note content and an edge to connect them.

~~~
diagram = statement_list.

statement_list = statement, (: statement_list :) .

statement = class_statement | object_statement | comment_statement |
        actor_statement | usecase_statement | relationship_statement .


property = ownership, identifier, type .
property = [ownership], identifier, [':', type], ['=' default_value] .

method = [ownership], identifier, '()' .

ownership = '@private' | '@public'    
~~~