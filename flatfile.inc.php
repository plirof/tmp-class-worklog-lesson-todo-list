<?php
date_default_timezone_set('Europe/Athens'); //added to avoid PHP warning for date 160920
#####################################################################################
# Flat File Database Manager 1.2jmod04-link object type 190223a
#
# changes
# ver1.2jmod04-link object type 190223a :
#   - Added red color to DELETE/MARK checkbox
#
#
# ver1.2jmod03-link object type 170716a
#####################################################################################
# Visit http://www.zubrag.com/scripts/ for updates
#####################################################################################
# Expects:
#
# Database file name, i.e. file with real data
# --> $data_file
#####################################################################################
# Database definition file. You have to describe database format in this file.
# Each row describes one field
# Allowed data types: 
# STRING:  Rendered as regular input field. Row format:
#          title,STRING,length
# TEXT:    Rendered as text area. Row format:
#          title,TEXT,columns,rows
# LOGICAL: Rendered as check box (flag). Row format:
#          title,LOGICAL,1,value for Yes,value for No
# LIST:    Rendered as list box or combo box. Row format:
#          title,LIST,number of rows visible at a time,colon ":" separated allowed values
# LINK:  Rendered as regular input field. Row format:  //JONMOD
#          title,LINK,length#
# Sample data definition file contents:
# City,LIST,3,City1:City2:City3:City4:City5
# State,LIST,1,NY:CA:LA
# Zip,STRING,8
# Active,LOGICAL,1,Y:N
# Comments,TEXT,30:2
# website,LINK,30
# --> $structure_file
######################################################################################
# Fields delimiter
# --> $delimiter
#####################################################################################

// strip slashes
if (get_magic_quotes_gpc()) {
  function stripslashes_deep($value) {
    $value = is_array($value) ? array_map('stripslashes_deep', $value) : (isset($value) ? stripslashes($value) : null);
    return $value;
  }

  $_POST = stripslashes_deep($_POST);
  $_GET = stripslashes_deep($_GET);
  //$_COOKIE = stripslashes_deep($_COOKIE);
}

$structure_tmp = file($structure_file);
$structure = array();
foreach($structure_tmp as $key=>$tmp) {
  /*if(strpos($tmp,':') === 0) {
    $code = explode(':',$tmp);
    ${$code[1]} = trim($code[2]);
    continue;
  }*/
  $line = explode(',',$tmp);
  $name_will_be = str_replace(' ','',trim($line[0]));
  foreach($structure as $key1=>$value1) {
    if ($value1['name'] == $name_will_be)
      die("Few columns have the similar name (not counting spaces): '{$line[0]}'. Please rename.");
  }
  $structure[$key]['name_original'] = trim($line[0]);
  $structure[$key]['name'] = str_replace(' ','',$structure[$key]['name_original']);
  $structure[$key]['type'] = trim($line[1]);
  if (isset($line[2])) $structure[$key]['format'] = trim($line[2]);
  if (isset($line[3])) {
    $values = explode(':',$line[3]);
    foreach($values as $item) {
      $structure[$key]['values'][] = trim($item);
    }
  }
}

// Save data (Submit button pressed)
if (isset($_POST['submit'])) {
  /////////////////////////////////////////////////

  if ($skip_lines > 0) {
    // read header lines
    $tmp_data = file($data_file);
  }

  $f = fopen($data_file,'w+');
  if ($f) {

    // save header back to file
    if ($skip_lines > 0) {
      for($i=0; $i < $skip_lines; $i++) {
        fputs($f,$tmp_data[$i]);
      }
    }

    for( $i=0; $i < count($_POST[$structure[0]['name']]); $i++ ) {
      // do not save records marked for delete
      if (isset($_POST['d_e_l_e_t_e'][$i])) continue;

      $s = '';
      $isfirst = true;
      foreach($structure as $key => $field) {
        $n1 = isset($_POST[$structure[$key]['name']]) ? $_POST[$structure[$key]['name']] : '';
        $v1 = isset($n1[$i]) ? $n1[$i] : $structure[$key]['values'][1];
        // remove new line characters as each new line represents new database row
        $v1 = str_replace(array("\r\n","\n","\r"),'',$v1);
        $s = $s . ($isfirst ? '' : $delimiter) . $v1;
        $isfirst = false;
      }
      // do not save empty lines
      if (trim(str_replace($delimiter,'',$s)) == '') continue;

      // save database record to file
      fputs($f,$s."\n");
    } // for
    fclose($f);
  } // if
  header("location: index.php");   //added jon 161112 by jon to avoid resubmissions  (if you restore session will always do a normal load)  
}

$data = file($data_file);

// skip header lines
if ($skip_lines > 0) $data = array_slice($data, $skip_lines);

// add "new line" holder
$data[] = str_repeat($delimiter,count($structure)-1);
//array_unshift($data, str_repeat($delimiter,count($structure)-1));//added by jon 160217


echo '<html>';
echo "<head><title>$data_file</title>
<script>
  function autoScrolling() { window.scrollTo(0,document.body.scrollHeight); }
  //setInterval(autoScrolling, 1000); //added by jon 160218 autoscroll bottom of page
</script>
</head>";
echo "<body><h1>$data_file</h1>

";
echo '<form method="post">';
echo '<table>'."\n";

// output header
echo '<tr style="background: #AAAAAA; border: 1px solid blue">';
foreach ($structure as $key=>$line) {
  echo "<th>{$line['name_original']}</th>";
}
echo '<th>Mark</th>';
echo '</tr>'."\n";

// output data
foreach($data as $datakey => $line) {

  // skip empty rows
  if (trim($line) == '') continue;

  echo '<tr style="background: #'.($datakey % 2 == 0 ? 'F0F0F0' : 'FAFAFA').'">';

  $items = explode($delimiter,$line);

  // any fields not defined? add empty
  while (count($items) < count($structure))
    $items[] = '';

  foreach ($items as $key => $item) {
    $item = htmlspecialchars(trim($item));
    $name = $structure[$key]['name'];
    echo "\n".'  <td valign="top">';
  //echo "<h1>$item</h1>";
    switch ($structure[$key]['type']) {
# STRING:  Rendered as regular input field. Row format:
#          title,STRING,length  
      case 'STRING':
        echo '<input onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" value="'.$item.'" size="'.$structure[$key]['format'].'" />';
        break;
# DATE:  Rendered as regular input field. Row format:    Added by jon
#          title,STRING,length      
      case 'DATE':   // added by jon 20141208
    
    if ($item==null) $item=date("Ymd");
        echo '<input onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" value="'.$item.'" size="'.$structure[$key]['format'].'" />';
        break;
# TEXT:    Rendered as text area. Row format:
#          title,TEXT,columns,rows

      case 'TEXT':
        $rc = explode(':',$structure[$key]['format']);
        $cols = trim($rc[0]);
        $rows = trim($rc[1]);
        echo '<textarea onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" rows="'.$rows.'" cols="'.$cols.'">'.$item.'</textarea>';
        break;
# LOGICAL: Rendered as check box (flag). Row format:
#          title,LOGICAL,1,value for Yes,value for No

    case 'LOGICAL':
        $val_yes = trim($structure[$key]['values'][0]);
        echo '<input onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" type="checkbox" '.(($item == $val_yes) ? 'checked' : '').' value="'.$val_yes.'" />';
        break;
// +++++++++++++++++++++++++ added by john to show a link (adds HTTP:// ) 20160428+++++++++++++++++++++++        
# LINK:  Rendered as regular input field (like STRING) but creates a link. Row format:
#          title,LINK,length  
      case 'LINK':
        $item = preg_replace("/^http:\/\//i", "", $item); //remove http from saved text NOTE might have to add http or https eventually jon 170716a
        $item = preg_replace("/^https:\/\//i", "", $item);//remove http from saved text NOTE might have to add http or https eventually jon 170716a
#        quicknotes_worklog_/flatfile.inc.php on line 203
        echo '<input onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" value="'.$item.'" size="'.$structure[$key]['format'].'" />';
//      echo '<BR><a href="http://'.$item.'" >'.$item.'</a>';
        echo '<BR><a href="http://'.$item.'" >LINK</a>';        
        break;        
// ------------------------ added by john to show a link (adds HTTP://)----------------------
# LIST:    Rendered as list box or combo box. Row format:
#          title,LIST,number of rows visible at a time,colon ":" separated allowed values   
      case 'LIST':
        echo '<select onchange="cdf('.$datakey.')" name="'.$name.'['.$datakey.']" size="'.$structure[$key]['format'].'">';
        foreach($structure[$key]['values'] as $value) {
          echo '<option value="'.$value.'" '.($value == $item ? 'selected' : '').'>'.$value.'</option>';
        }
        echo '</select>';
        break;
    }
    echo '</td>';
  }  // end of   foreach ($items as $key => $item) {
  
  // Mark for delete if last record (i.e. Add option). In this way we'll skip adding empty records
  
  echo "\n  <td><div style='background-color: red;'><input id='d_e_l_e_t_e[{$datakey}]'  name='d_e_l_e_t_e[{$datakey}]' type='checkbox' ".($datakey == count($data)-1 ? 'checked' : '')." /></div></td>";
  echo "\n</tr>\n";

}

echo '<tr><td colspan=255 align=center><input type="submit" name="submit" value="Save Changes and Delete marked" style="border:1px solid red"></td></tr>';
echo '</table>';
echo "</form>

<script>
function cdf(theid) {
document.getElementById('d_e_l_e_t_e['+theid+']').checked = false;
}
</script>";

include('show_filter.php'); //added 181020a jon to display a list of options to filter rows   


echo "
<script>
autoScrolling();
</script>
";

echo '</body>';
echo '</html>';

?>