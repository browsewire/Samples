<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Goutte\Client;

/** Model used **/
use App\Post;
use App\Category;
use App\Tag;
use App\Ptags;
use App\Ptopics;


/**
 * There you are at the new controller
 */
class DemoController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	   
      $client = new Client();
      
      $parentURL = 'http://archive-grbj-2.s3-website-us-west-1.amazonaws.com/';   
      $crawler = $client->request('GET', $parentURL);
      $crawler->filter('#section-1 .record')->each(function ($node1) {
      
      $oldpost = Post::where('title', '=', trim($node1->filter('h2')->text()))->first();
      if(!$oldpost){
     
      $client2 = new Client();
      $innerURL = 'http://archive-grbj-2.s3-website-us-west-1.amazonaws.com/'.trim($node1->filter('h2 a')->attr('href'));
      $crawlerInner = $client2->request('GET', $innerURL);
     
      $crawlerInner->filter('#section-2')->each(function ($node) {
      
      
      $topicsArray = $node->filter('#section-2 .record .topic')->each(function($topics){
      $cate = Category::where('title', '=', trim($topics->text()))->first();
      if(!$cate){
      $category = new Category;
      $category->title = trim($topics->text());
      $category->slug = $this->convert_to_slug(trim($topics->text()));
      $category->save();
      return $category->id;
      }else{
      return $cate->id;
      }
      
      });
      $topicslist = implode(', ',$topicsArray);
      
      $tagsArray = $node->filter('#section-2 .toolbar-wrap .tags a')->each(function($tags){
      //return trim($tags->text());
      $ptags = Tag::where('title', '=', trim($tags->text()))->first();
      if(!$ptags){
      $newTag = new Tag;
      $newTag->title = trim($tags->text());
      $newTag->slug = $this->convert_to_slug(trim($tags->text()));
      $newTag->save();
      return $newTag->id;
      }else{
      return $ptags->id;
      }
      
      });
      $tagslist = implode(', ',$tagsArray);
      
       $post = new Post;
       $post->title = trim($node->filter('#section-2 h1')->text());
       $post->created = trim($node->filter('#section-2 .meta .date')->text());
       $post->author = str_replace('|','',str_replace('By','',trim($node->filter('#section-2 .meta .author')->text())));
       $post->url = $node->getURI();
       $post->slug = $this->convert_to_slug(trim($node->filter('#section-2 h1')->text()));
       //$post->topics ='';//$topicslist;
       //$post->category_id =$topicslist;
       //$post->tag_id =$topicslist;
       //$post->tags ='';//$tagslist;
       $post->content = trim($node->filter('#section-2 .content .body')->html());
       $post->save();
       $newpostID = $post->id;
       foreach($tagsArray as $tagid){
       $tagTitle = Tag::find($tagid);
       $ptag = new Ptags;
       $ptag->post_id  =$newpostID;
       $ptag->tags_id =$tagid;
       $ptag->tag_title=$tagTitle->title;
       $ptag->save();
       }
       
       foreach($topicsArray as $catid){
       $categoryTitle = Category::find($catid);
       $pTopic = new Ptopics;
       $pTopic->post_id  =$newpostID;
       $pTopic->category_id =$catid;
       $pTopic->category_title=$categoryTitle->title;
       $pTopic->save();
       }
       
      
     }); 
     } 
    });
   
    
    $posts = Post::orderBy('title', 'ASC')->paginate(6);

    return view('index', array('posts' => $posts) );
    
    
  }
  
  
  
  /**
	 * Display a listing of the resource by Category slug.
	 *
	 * @return Response
	 */
	public function bycategory($id)
	{
	   $category = Category::where('slug', '=', $id)->first();
     $categlist = Category::findOrFail($category->id)->cposts()->paginate(6);
     return view('catindex', array('type'=>'Category','categlist' => $categlist,'posttype'=>$category) );
    
    
  }
  /**
	 * Display a listing of the resource by Tag slug.
	 *
	 * @return Response
	 */
	public function bytag($id)
	{
	   
    $tag = Tag::where('slug', '=', $id)->first();
    $taglist = Tag::findOrFail($tag->id)->cposts()->paginate(6);
    return view('catindex', array('type'=>'Tag','categlist' => $taglist,'posttype'=>$tag) );
    
    
  }
  
  public function newpost(Request $request)
	{
	

    $post = new Post;
    $post->title = $request->input('title');
    $post->author = $request->input('author');
    $post->url = $request->input('url');
    $post->topics = $request->input('topics');
    
    $post->save();
    // return the view with the data
		return redirect()->route('index');
  }

	function convert_to_slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return rtrim($str, '-');
 
  }
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		 $post = Post::where('slug', '=', $id)->first();
		 
		 $data = Post::orderBy('id', 'DESC')->paginate(10);
		 // get previous user id
		  $previous = $next = '';
		  $prevID = Post::where('id', '<', $post->id)->max('id');
      if($prevID){
      $previous= Post::where('id', '=', $prevID)->first();
      }

      // get next user id
      $nextID = Post::where('id', '>', $post->id)->min('id');
      if($nextID){
      $next= Post::where('id', '=', $nextID)->first();
      }
      
		 return view('show', ['data' => $data,'post' => $post,'previous'=>$previous,'next'=>$next]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		 $post = Post::find($id);
		 return view('edit', compact('post'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		 $post = Post::find($request->input('id'));
		 $post->title = $request->input('title');
     $post->author = $request->input('author');
     $post->url = $request->input('url');
     $post->topics = $request->input('topics');
    
     $post->save();
     // return the view with the data
		 return redirect()->route('index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		 $post = Post::find($id);
     $post->delete();
     return redirect()->route('index');
	}

}