<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposedProjects;
use App\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\AdminSettings;

class ProposedProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = ProposedProjects::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->take(10)->get();

        return view('users.propose-project', compact('projects'));
    }

    /**
     * Display proposed projects list in admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $projects = ProposedProjects::where('submitted', 1)->orderBy('id', 'desc')->get();

        return view('admin.proposed-projects.index', compact('projects'));
    }

    /**
     * Display proposed projects list in admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminValidate(Request $request)
    {
    	$id = (int) $request->validate;
    	$project = ProposedProjects::where(['id'=> $id, 'submitted'=> 1])->first();
    	$project->validated = 1;
    	$project->save();

        $projects = ProposedProjects::where('submitted', 1)->orderBy('id', 'desc')->get();

        return redirect()->route('proposed-projects-list')->with('notification', 'misc.project_validated');
    }

    /**
     * Display proposed projects list in admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$project = ProposedProjects::where(['id'=> $id, 'submitted'=> 1])->first();
    	$user = User::where('id', $project->user_id)->first();
    	$settings = AdminSettings::first();
    	//dd($settings);
        return view('admin.proposed-projects.show', compact('project', 'user', 'settings'));
    }

    /**
     * Store a proposed project.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$slug = str_slug($request->input('name'));

    	$request->request->add(['slug' => $slug]);
    	$request->request->add(['user_id' => Auth::user()->id]);

       	$rules = ProposedProjects::$rules;
        $submitValidator = Validator::make($request->all(), $rules);

        $validator = Validator::make($request->All(),['name'=>'required|unique:proposed_projects,name']);
        if($validator->fails()){
    	    return redirect()->back()->withErrors($validator)->withInput();
    	}

    	$project = ProposedProjects::create($request->Except(['submit']));
        
        if($request->get('submit') == 'saveSubmit'){

        	if($submitValidator->fails()){
    	       return redirect()->back()->withErrors($submitValidator)->withInput();
    	    }

    	    $project->update(['submitted' => 1]);

			return redirect()->route('proposed-project.new')->with('notification', 'misc.project_submitted');
    	}

        return redirect()->route('proposed-project.edit', [$project])->with('notification', 'misc.project_saved');
    }

    /**
     * Edit a proposed project.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = ProposedProjects::find($id);
       
        $projects = ProposedProjects::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->take(10)->get();

        return view('users.propose-project', compact('project', 'projects'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    	$project = ProposedProjects::find($id);
   		
   		$rules = ProposedProjects::$rules;
        $validator = Validator::make($request->all(), $rules);

    	$project->update($request->Except(['name', 'submit']));
        $project->save();

        if($request->get('submit') == 'saveSubmit'){

        	if($validator->fails()){
    	       return redirect()->back()->withErrors($validator)->withInput();
    	    }

    	    $project->update(['submitted' => 1]);

			return redirect()->route('proposed-project.new')->with('notification', 'misc.project_submitted');
    	}

        return redirect()->route('proposed-project.edit', [$project])->with('notification', 'misc.project_updated');
    }

    /**
     * Display proposed projects list in admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    	$project = ProposedProjects::where(['id'=> $request->id, 'submitted'=> 1,])->first();
    	
    	$project->delete();
     	
     	return redirect()->route('proposed-projects')->with('notification', 'misc.project_deleted');
    }
}
