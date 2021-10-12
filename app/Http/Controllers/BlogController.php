<?php

namespace App\Http\Controllers;

use App\Models\blog;
use Illuminate\Http\Request;
use Auth;
class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create');
        $this->middleware('auth')->only('edit');
        $this->middleware('auth')->only('destroy');
        $this->middleware('auth')->only('update');
        $this->middleware('auth')->only('store');
    }
    public function index()
    {
        $Blogs=Blog::where('status','1')->where('end_date', '>=', date('Y-m-d'))->get();
        if (Auth::check() && Auth::user()->role_id=="1") {  
                $Blogs=Auth::user()->Blogs()->where('status','1')->where('end_date', '>=', date('Y-m-d'))->get();
            }
            elseif (Auth::check() && Auth::user()->role_id=="2") {
                  $Blogs=Blog::all();
            }
        return view('blogs.index',compact('Blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request;
        $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'image' => ['required'],
        ]);

        $image = $request->file('image');
        $name  = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/blogimages');
        $image->move($destinationPath, $name);
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image' => $name,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($blog_id)
    {
        $blog=Blog::Findorfail($blog_id);
        if ($blog->status==1) {
            $blog->status='0';
        }
        else{
            $blog->status='1';
        }
        $blog->save();
        return redirect()->route('blogs.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(blog $blog)
    {
        if (Auth::user()->role_id=='2') {
            return view('blogs.edit',compact('blog'));
        }
        else{
            if ($blog->user_id==Auth::user()->id) {
                    return view('blogs.edit',compact('blog'));
                }
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, blog $blog)
    {
        // return $request;
        $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name  = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/blogimages');
            $image->move($destinationPath, $name);
            $blog->image=$name;
        }
        $blog->title=$request->title;
        $blog->description=$request->description;
        $blog->start_date=$request->start_date;
        $blog->end_date=$request->end_date;
        $blog->save();
    
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(blog $blog)
    {

        if (Auth::user()->role_id=='2') {
            return view('blogs.edit',compact('blog'));
        }
        else{
            if ($blog->user_id==Auth::user()->id) {
                    $blog->delete();
                    return redirect()->route('blogs.index');
                }
            return redirect()->back();
        }
    }
}
