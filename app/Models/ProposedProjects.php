<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use Illuminate\Support\Facades\Validator;

class ProposedProjects extends Model
{
    //protected $fillable = ['name', 'country', 'town', 'amount', 'campaign_duration', 'description','counterparts', 'project_holder_intro'];

    protected $guarded = [];

    public static $rules =[
    	
    	'country'=>'required',
    	'town'=>'required',
    	'amount'=>'required',
    	'campaign_duration'=>'required',
    	'description'=>'required|max:600',
    	'counterparts'=>'required|max:600',
    	'project_holder_intro'=>'required|max:600',
    ];

}
