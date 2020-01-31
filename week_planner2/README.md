# week_planner2



Changes:




Bugs:
Bug: Τα κενά στο αρχείο δημιουργούν προβλήματα. Να αφαιρούνται... (FIXED in v1.2jmod006_190305)


## Weeklist
```javascript
01
02
03
04
05
06
07
08
09
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37

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