auth
====
Copyright 2014 Valentin Wagner
All rights reserved.
Alle Rechte vorbehalten.


short update log thursday night:
added proper session support
moved a whole bunch of code around, put into functions, modularized
in theory, sessions should work now
but they don't
at least not on sabitum
we'll have to try it on lg.de


short update log saturday:
session support now working
tried on lg.de
added support for GET paramater (vertretungsplan.leiningergymnasium.de/index.php?pid=1) will echo tomorrow
we'll just have to get the RewriteRules working
I have a .htaccess on sabitum, i'll add it in the next commit
also outsourced the dbp to file dbp which is untracked
the dbp should be changed as soon as possible, it was on here in plaintext
