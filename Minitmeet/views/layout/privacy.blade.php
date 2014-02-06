<?php $policy = DB::table('policy')->get();
    foreach($policy as $value){
		
	echo $value->content;	
		
	}
?>

