<?php
/*** DESCRIPTION 
|
|   controlling our tour page
|   e.g http://www.domain.com/tour
|   will be directed to view\tour\index.php
|   and handled thorugh action_index() function
|
***/

class TourController extends BaseController
{
    public function index()
    {
	 $query="select image from tour_image where pagename='overview' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));	
	 $title= DB::table('tour_content')->where('pagename','=','overview')->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=','overview')->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=','overview')->first();
	 $seo = DB::table('tour_seo')->where('pagename','=','overview')->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);
	
    }
    public function createpage($url){
		if(empty($url)){
	 $query="select image from tour_image where pagename='overview' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));	
	 $title= DB::table('tour_content')->where('pagename','=','overview')->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->where('parentpage','tour')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=','overview')->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=','overview')->first();
	 $seo = DB::table('tour_seo')->where('pagename','=','overview')->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);
	
			
		}else		
	 $page=DB::table('tour_seo')->where('url',$url)->lists('pagename');
	 $pagename=$page[0];   	
	 $query="select image from tour_image where pagename='".$pagename."' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));			
     $title= DB::table('tour_content')->where('pagename','=',$pagename)->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->where('parentpage','tour')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=',$pagename)->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=',$pagename)->first();
	  $seo = DB::table('tour_seo')->where('pagename','=',$pagename)->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);
	
	}

    public function create()
    {
     $query="select image from tour_image where pagename='create minute' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));	
	 $title= DB::table('tour_content')->where('pagename','=','create minute')->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=','create minute')->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=','create minute')->first();	
	  $seo = DB::table('tour_seo')->where('pagename','=','create minute')->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);

    }

    public function contacts()
    {
		
     $query="select image from tour_image where pagename='contacts' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));	
	 $title= DB::table('tour_content')->where('pagename','=','contacts')->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=','contacts')->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=','contacts')->first();	
	  $seo = DB::table('tour_seo')->where('pagename','=','contacts')->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);

		
		
    }

    public function pdf()
    {
		
     $query="select image from tour_image where pagename='pdf' LIMIT 1,50";
	 $image = DB::select(DB::raw($query));	
	 $title= DB::table('tour_content')->where('pagename','=','pdf')->distinct()->get(array('title'));	
	 $link = DB::table('tour_content')->where('parentpage','tour')->distinct()->orderBy('id','asc')->get(array('pagename'));
	 $data = DB::table('tour_content')->where('pagename','=','pdf')->get();	 
	 $firstimage = DB::table('tour_image')->where('pagename','=','pdf')->first();	
	  $seo = DB::table('tour_seo')->where('pagename','=','pdf')->get();	 	
	 return View::make('tour.index')->with('data',$data)->with('image',$image)->with('link',$link)->with('title',$title)->with('first_image',$firstimage)->with('seo',$seo);

    }
  
  public function getcustom($url){

	  $pagename = DB::table('tour_seo')->where('url',$url)->lists('pagename');	    
	  $data = DB::table('tour_content')->where('pagename',$pagename[0])->get();
	  $seo = DB::table('tour_seo')->where('pagename',$pagename[0])->get();
	  return View::make('custom')->with('data',$data)->with('seo',$seo);   
  
  }  
 
  
    public function settings()
    {
        return View::make('tour.settings');
    }

}
