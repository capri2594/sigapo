<?php
//note: if word file for dump desired, link to this page like:
//<a href='dump.php?w=1'>link</a>
//if this parameter is not included, file returned will be in excel format
if ($w==1){
$file_type = "msword";
$file_ending = "doc";
}
else {
$file_type = "vnd.ms-excel";
$file_ending = "xls";
}
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=database_dump.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");
//get contents
//define date for title
$now_date = date('d-m-Y H:i');
$title = "eEvaluation Seminar List for $now_date";
$sql = "Select * from bnet_eng_tracking";

/*    Database Connection (Alternative- for mysql_fetch_array)    */
Require("connect_defs.php");

$result = @mysql_query($sql,$ALT_Connect)
	or die(mysql_error());
//end of connection code

//define separator (defines columns in excel)
$sep = "\t";

//print excel header with timestamp:
echo("$title\n");

//start of printing column names
for ($i = 0; $i < mysql_num_fields($result); $i++) {
echo mysql_field_name($result,$i) . "\t";
}
print("\n");
//end of printing column names

//start while loop to get data
/*      
note: the following while-loop was taken from phpMyAdmin 2.1.0.
--from the file "lib.inc.php".
*/
    $i = 0;
    while($row = mysql_fetch_row($result))
    {
        //set_time_limit(60); // HaRa
        $schema_insert = "";
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert .= "\t";
        print(trim($schema_insert));
		print "\n";
        $i++;
    }
    return (true);
?>
