# tmp-class-worklog-lesson-todo-list
modification of class-worklog to create a lesson planner for all the schoolyear weeks TEST-do NOT use



Changes:
flatfile.inc_1.2jmod006_190305_ignore_empty_lines.php



Bugs:
Bug: Τα κενά στο αρχείο δημιουργούν προβλήματα. Να αφαιρούνται... (FIXED in v1.2jmod006_190305)


## Paths from john_start script
```javascript
CODEorg=https://studio.code.org/s/course1/stage/
LANDINGpages="http://192.168.1.200/uploads/landing_pages/"
SWFlocal="http://192.168.1.200/swf/"
SWFpath="http://192.168.1.200/swf/"
SWFgiortes="http://192.168.1.200/swf/swf_giortes/"
GAMESEDU="http://192.168.1.200/gamesedu/"

OOOKIDS="ooo4kids1.3 -n "
OOOKIDSpathprefix="/opt/lampp/htdocs/askiseis_office/"
RAMKIDpathprefix="http://192.168.1.200/ramkid/"

```

## Sublime editor add in start of line 
Insert text every beginning of line



I have 1000 line following like structure texts.

f54g
f5g546
2122v
kjfkjlf
ttt54
ncjkhd8
DFSD5

But i want beginning insert text "Token".How do insert this text for 1000 lines?

Token f54g
Token f5g546
Token 2122v
Token kjfkjlf
Token ttt54
Token ncjkhd8
Token DFSD5


Ctrl+A selects the whole file content.
Ctrl+Shift+L let you get cursors on lines of selected regions.
Home moves cursors to the line beginning.
Type Token_.
Another way:
- Ctrl+H with regex mode enabled and replace ^ with Token_.