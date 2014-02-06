<?php
// application/controllers/account.php
class OrderController extends BaseController
{
	
	public function getdetail(){
	 $data=DB::table('transaction_id')->where('status','=','0')->paginate(10);
	 return View::make('admin.payment')->with('data',$data);	
		
	}
	public function geteditform($id){
		$data=DB::table('transaction_id')->where('id','=',$id)->first();
		return View::make('payment.orderedit')->with('data',$data);
		
	}
	public function posteditform($id){
		 print_r($_POST); 
		 
		DB::table('transaction_id')->where('id','=',$id)->update(Input::all());
		$data=DB::table('transaction_id')->where('status','=','0')->paginate(10);
	    return View::make('admin.payment')->with('data',$data);
		
	}
	public function getorderpage($id){
		
	 $data=DB::table('transaction_id')->where('status','=','0')->paginate(10);
	 return View::make('admin.payment')->with('data',$data);	
	}
	public function postorderremove(){
	  DB::table('transaction_id')->where('status','=','0')->update(array('status'=>'1'));
	   $data=DB::table('transaction_id')->where('status','=','0')->paginate(10);
	 return View::make('admin.payment')->with('data',$data);		
		
	}
	
}


?>
