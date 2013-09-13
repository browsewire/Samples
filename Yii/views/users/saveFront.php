<?php
	// Get the data
	$imageData=$_POST['src'];

	// Remove the headers (data:,) part.  
	// A real application should use them according to needs such as to check image type
	$filteredData=substr($imageData, strpos($imageData, ",")+1);

	// Need to decode before saving since the data we received is already base64 encoded
	$unencodedData=base64_decode($filteredData);

	//echo "unencodedData".$unencodedData;

	// Save file.  This example uses a hard coded filename for testing, 
	// but a real application can specify filename in POST variable
//fopen( 'test.png', 'w' );
	$fp = fopen( 'front.png', 'w' );
	fwrite( $fp, $unencodedData);
	fclose( $fp );
 
?>

