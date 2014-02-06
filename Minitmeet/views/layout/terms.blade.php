
        <span class="terms-head">Minitmeet.com Terms of Service</span><br><br>

Welcome to Minitmeet.com!<br><br>
<?php $term = DB::table('terms')->get();
foreach ($term as $value){
	
	?>
	<span class="section"> {{$value->heading}}   </span><br><br>
<div class="sub-section">{{$value->description}}
    <br><br></div>
    <?php

	
}?>
