<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper;
use DevDojo\Chatter\Models\Models;

class ForumController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function createCategory(Request $request) {

		if($request->All()){ 

			$validator = Validator::make($request->all(), [
	            'name' => 'required|unique:chatter_categories,name,',
			 ]);

			if ($validator->fails()) {
			    return back()->withErrors($validator)->withInput();
			}

			$request->request->add(['slug' => str_slug($request->input('name'))]);

			$category = Models::category();
			
	        $category->name = $request->name;
	        $category->slug = $request->slug;

	        $category->save();

			return view('admin.forum.index');
		}



		return view('admin.forum.new_category');
    }

    public function updateCategory(Request $request, $id=null) {
       
        $category = Models::category()->findOrFail($request->id);
        
    	if($request->All()){ 
           
    		$validator = Validator::make($request->all(), [
                'name' => 'required|unique:chatter_categories,name,',
    		 ]);

    		if ($validator->fails()) {
    		    return back()->withErrors($validator)->withInput();
    		}

    		$call = $request->request->add(['slug' => str_slug($request->input('name'))]);
    		
            $category->name = $request->name;
            $category->slug = $request->slug;

            $category->save();

    		return view('admin.forum.index');
    	}

    	return view('admin.forum.edit', compact('category'));

    }

    public function destroyCategory(Request $request) {
		
    	$category = Models::category()->find($request->id);
        $category->delete();

        return view('admin.forum.index');
    }    	
}
