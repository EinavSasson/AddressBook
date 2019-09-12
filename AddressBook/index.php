<?php
	echo "This is my php file, that creates html file with csv data. Check your new index html file in browser.";
	//recive parameter the path to a csv file
    $_GET["csv"];
	$address_book = "C:/xampp/htdocs/address_book.csv";
    $sort_array = array();
	$cities = array();

	if (($handle = fopen($address_book, "r")) !== FALSE) {
		$text_to_html = "<table border='1'>";
		$sum = array();
		
		while (($data = fgetcsv($handle, 1000)) !== FALSE) {
			array_push($sum, $data[0]);
	     	array_push($sort_array, $data);
			$num = count($data);
			
			//echo "<p> $num fields in line <br /></p>\n";
			if ( $data[0] == "first_name" ) {
				//first loop of while will print table header
				$text_to_html .=  "<tr><th>";
				for ($c=0; $c < $num; $c++) {
					//echo $data[$c] . "<br />\n";
					$text_to_html .= $data[$c] . "</td><td>";			
				}
				$text_to_html .= "</th></tr>";
			} else {
				$text_to_html .= "<tr><td>";

				
				$first_name = $data[0];
				$last_name = $data[1];
				$phone_number = $data[2];
				$street = $data[3];
				$city = $data[4];
				$zip_code = $data[5];
					
				$text_to_html .= "<button onclick='alert(\"Name: $first_name\\nLast Name: $last_name\\nPhone Number: $phone_number\\nStreet: $street\\nCity: $city\\nZip Code: $zip_code\")'>" . $first_name. "</button>"."</td><td>";
				$text_to_html .= $last_name . "</td><td>";
				$text_to_html .= $phone_number . "</td><td>";
				$text_to_html .= $street . "</td><td>";
				$text_to_html .= $city . "</td><td>";
				$text_to_html .= $zip_code . "</td></td>"; 
				
				$text_to_html .= "</td></tr>"; 
				
				//summary, how many users have from every city 
				if(isset($cities[$city])){
                $cities[$city]++;
                 }else {
                $cities[$city] = 1;
				
                 }
			}
			
		}
		
		fclose($handle);

		$last_name = array_column($sort_array, 1);
		array_multisort($last_name, SORT_ASC, $sort_array);
		
	    //var_dump($sort_array);
	   	      
		  /* 
		  foreach ($sort_array as $key => $row) {
         $names[$key]  = $row[1];
	 }
	 array_multisort(array_column($sort_array, 1), SORT_ASC, $sort_array);
	 */
	 
	

	$text_to_html .= "</table>";
	//display the users have from every city
	$text_to_html .= "<p>Summary of contacts from each city: <br/></p>" . array_sum($cities) ;
	$filename = "index.html";
    $fp = fopen($filename, "a");
    $str = print_r($text_to_html, true); 
    fwrite($fp, $str);
    fclose($fp);
	}
			
?>
