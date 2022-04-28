<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function index(){
        $showBlog = Blogs::all();
        return response($showBlog,200);
    }

    public function show($uniq_id)
    {
        $showBlogById = Blogs::where("uniq_id",$uniq_id)->first();
        return response($showBlogById);
    }

    public function store(Request $request)
    {
        if($request->title == null)
        {
            return response()->json([
                'Message:'=>'Title boş ola bilməz',
            ]);
        }

        if($request->content == null)
        {
            return response()->json([
                'Message:'=>'Content boş ola bilməz',
            ]);
        }

        if($request->is_active == null)
        {
            return response()->json([
                'Message:'=>'Acive boş ola bilməz',
            ]);
        }

        $createBlog = Blogs::create([
            "uniq_id" => Str::uuid(),
            "title" => $request->title,
            "content" => $request->content,
            "isActive" => $request->is_active,
        ]);
        
    
        if($createBlog == true)
        {
            return response()->json([
                'Message :'=>'Yeni Blog ugurla elave edildi',
                'title:'=> $request->title,
                'content:'=>$request->content,
                'isActive:'=>$request->is_active,
                'Time'=>Carbon::now()->format('d-M-Y'),
            ]);
        }
        else
        {
            return response()->json([
                'Message:'=>'Blogu daxil etmek mumkun olmadi',
            ]);
        }
    }

    public function register(Request $request)
    {

        $validated = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
    ]);
          $user = new User();
          $user->name = $request->name;
          $user->email = $request->email;
          $user->password = bcrypt($request->password);
          $user->save();
          $token = $user->createToken('token_name')->plainTextToken;
          $response = ['token'=>$token, 'user'=> $user];
          return response ($response, 201);
    }
 
         public function update(Request $request, $uniq_id)
         {
                
               $affected = DB::table('blogs')
              ->where('uniq_id', $uniq_id)
              ->update(['title' => $request->title,'content' => $request->content,'isActive'=> $request->is_active]);
            if($affected == true)
            {
                return response()->json([
                'message' => 'Melumatlar ugurla yenilendi',
                'title' => $request->title,
                'content' => $request->content,
                'isActive'=>$request->is_active,
            ]);
            }
            else
            {
                return response()->json([
                    'message' => 'Melumatlari yenilemek ugursuz oldu',
                ]);
            }
              
         }

        public function destroy ($uniq_id)
        {
            $delete = DB::table('blogs')->where('uniq_id', $uniq_id)->delete();
            if($delete == true)
            {
                 return response()->json([
                'message' => 'Melumat ugurla silindi',
            ]);
            }

            else
            {
                return response()->json([
                    'Message :' => 'Melumati silmek ugursuz oldu',
                ]);
            }
            
        }  
    
}
