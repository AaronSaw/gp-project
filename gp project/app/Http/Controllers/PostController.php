<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =
        //Post::rightJoin('users','posts.user_id','=','users.id','')

        Post::leftJoin('users','posts.user_id','=','users.id','left outer')
        ->leftJoin('categories','posts.category_id','=','categories.id')
        ->select('posts.*','users.name')








        //DB::table('categories')->select(DB::raw('*'))
        //->join('posts','posts.category_id','=','categories.id')
        ->when(request('title'), function ($q) {
            $title = request("title");
            $q->where("title", "like", "%$title%");
        })
        ->when(request('user'), function ($q) {
            $user = request("user");
            $q->where("users.name", "like", "%$user%");
        })
        ->when(request('ctitle'), function ($q) {
            $ctitle = request("ctitle");
            $q->where("categories.title", "like", "%$ctitle%");
        })
        ->when(request('sdate'), function ($p) {
            $sDate = request("sdate");
            $p->where("posts.created_at", ">", "$sDate");
        })
        ->when(request('edate'), function ($e) {
            $eDate = request("edate");
            $e->where("posts.created_at", "<", "$eDate");
        })
        ->when(request('description'), function ($e) {
            $description = request("description");
            $e->where("description", "like", "%$description%");
        })
    //->select('posts.id','posts.title','posts.description','users.name')
    ->paginate(5)->withQueryString();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        function textFilter($text)
        {
            $text = trim($text);
            $text = htmlentities($text, ENT_QUOTES);
            $text = stripslashes($text);
            return $text;
        }

        //dd( textFilter($request->summernote) );
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = textFilter($request->description);
        $post->price = $request->price;
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->category;

        if ($request->hasFile('featured_image')) {
            $newName = uniqid() . "_featured_image." . $request->file('featured_image')->extension();
            $request->file('featured_image')->storeAs("public", $newName);
            //            $request->file('featured_image')->storeAs("public",$newName,'public');
            //            Storage::putFileAs("/",$request->featured_image,$newName);
            //            $request->featured_image->storeAs();
            $post->featured_image = $newName;
        }
        $post->save();
        return redirect()->route('post.index')->with('status', "$post->title is add successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return   view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //return $post;
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if (Gate::denies('update', $post)) {
            return abort(403);
        }


        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description, 50, '...');
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->category;

        if ($request->hasFile('featured_image')) {
            //delete old  photo
            Storage::delete("public/" . $post->featured_image);

            //update photo
            $newName = uniqid() . "_featured_image." . $request->file('featured_image')->extension();
            $request->file('featured_image')->storeAs("public", $newName);
            //            $request->file('featured_image')->storeAs("public",$newName,'public');
            //            Storage::putFileAs("/",$request->featured_image,$newName);
            //            $request->featured_image->storeAs();
            $post->featured_image = $newName;
        }
        $post->update();
        return redirect()->route('post.index')->with('status', "$post->title is updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Gate::denies('delete', $post)) {
            return abort(403);
        }

        if (isset($post->featured_image)) {
            Storage::delete("public/" . $post->featured_image);
        }

        $post->delete();
        return redirect()->route('post.index')->with('status', "$post->title is deleted successfully");
    }

    public static function viewRecord($user_id, $post_id, $device)
    {
        $view = new View();
        $view->user_id = $user_id;
        $view->post_id = $post_id;
        $view->device  = $device;
        $view->save();
    }

    public static function  countTotal($table, $description)
    {
        //dd($description);

      $count=  DB::table("$table")->select(DB::raw('COUNT(id) as count_id'))
        ->whereRaw('CAST(updated_at AS DATE) = ?',[$description])
        ->first();
        return $count->count_id;
    }

    public static function countPost($table,$description){

      $count=  DB::table("$table")->select(DB::raw('COUNT(id) as count_id'))
      ->whereRaw('category_id = ?',[$description])
      ->first();
      return $count->count_id;
    }
}
