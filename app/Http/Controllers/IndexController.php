<?php namespace App\Http\Controllers;

//use App\Post as Post;
//use App\Repositories\Posts\PostRepositoryInterface as Post;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IndexController extends Controller {
    
    //protected $layout = 'layouts.master';

    /**
     * Show the index page.
     */
    public function showIndex()
    {
        //get the 4 most recent posts to show for the latest posts section
       //$posts = $post->getRecent(4);
       //return view('index')->with('posts',$posts);
        return view('index');
    }
    
     public function showAbout(){
        
        //$this->layout->content = View::make('about');
        return view('about');
    }

	public function showBootstrapExamples(){
		return view('bootstrap-examples');
	}

}