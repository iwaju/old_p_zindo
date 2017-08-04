<?php 
// ** Data User logged ** //
     $user = Auth::user();
     $settings = App\Models\AdminSettings::first();
     //dd($project->amount);
	  ?>
@extends('app')

@section('title') {{ trans('misc.propose_project') }} - @endsection

@section('content') 
<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">
        <h2 class="title-site">{{ trans('misc.propose_project') }}</h2>
      </div>
    </div>

<div class="container margin-bottom-40">
	
		<!-- Col MD -->
		<div class="col-md-8 margin-bottom-20">
			@if (Session::has('notification'))
			<div class="alert alert-success btn-sm alert-fonts" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		{{ trans(Session::get('notification')) }}
            		</div>
            	@endif
            	
            	 @if (Session::has('incorrect_pass'))
			<div class="alert alert-danger btn-sm alert-fonts" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		{{ Session::get('incorrect_pass') }}
            		</div>
            	@endif
            	
			@include('errors.errors-forms')
					
		<!-- ***** FORM ***** -->	
           <form method="POST" action= @if(isset($project)) "{{ route('proposed-project.update',['id'=>$project->id]) }}"
             @else "{{ route('proposed-project.store') }}" @endif role="form">
            {{ csrf_field() }}
              <!-- Start Form Group -->
              <div class="form-group">
                <label>{{ trans('misc.project_name') }}</label>
                <input type="text" @if(isset($project)) value="{{$project->name}}" disabled @else value="{{ old('name') }}" @endif name="name" id="name" class="form-control" placeholder="{{trans('misc.project_name')}}">
              </div><!-- /.form-group-->

              <div class="form-group has-feedback">
                <label class="font-default">{{ trans('misc.country') }}</label>
                <select name="country" class="form-control" >
                  <option value="">{{trans('misc.select_your_country')}}</option>
                  @foreach(  App\Models\Countries::orderBy('country_name')->get() as $country )   
                      <option @if( isset($project) && $project->country == $country->country_name ) selected="selected" @elseif ($user->countries_id == $country->id) selected="selected" @endif value="{{$country->country_name}}">{{ $country->country_name }}</option>
                  @endforeach
                </select>
              </div><!-- ***** Form Group ***** -->

              <div class="form-group">
                <label>{{ trans('misc.town') }}</label>
                <input type="text" value="@if( isset($project)){{ $project->town }} @else {{ old('town') }}@endif" name="town" id="town" class="form-control" placeholder="{{ trans('misc.town') }}">
              </div><!-- /.form-group-->
                 
              <!-- Start Form Group -->
              <div class="form-group">
                <label>{{ trans('misc.amount_to_collect') }}</label>
                <div class="input-group">
                  <div class="input-group-addon addon-dollar">{{$settings->currency_symbol}}</div>
                  <input type="number" min="1" class="form-control" name="amount" id="onlyNumber" 
                  value="@if(isset($project)){{$project->amount}}@else{{ old('amount') }}@endif" placeholder="30000">
                </div>
              </div>
                         
             <!-- Start Form Group -->
              <div class="form-group">
                 <label>{{ trans('misc.campaign_duration') }}</label>
                   <input type="text" value="@if( isset($project)){{ $project->campaign_duration }}@else {{ old('campaign_duration') }}@endif" name="campaign_duration" class="form-control" placeholder="{{ trans('misc.campaign_duration') }}">
              </div><!-- /.form-group-->

              <div class="form-group">
                 <label>{{ trans('misc.project_description') }}</label>
                  <textarea name="description" rows="4" id="description" class="form-control tinymce-txt" placeholder="{{ trans('misc.project_description') }}">@if( isset($project)) {{ $project->description }} @else {{ old('description') }} @endif</textarea>
              </div>

              <div class="form-group">
                 <label>{{ trans('misc.project_counterparts') }}</label>
                  <textarea name="counterparts" rows="4" id="counterparts" class="form-control tinymce-txt" placeholder="{{ trans('misc.project_counterparts') }}">@if( isset($project)) {{ $project->counterparts }} @else {{ old('counterparts') }}@endif</textarea>
              </div>

              <div class="form-group">
                 <label>{{ trans('misc.project_holder_intro') }}</label>
                  <textarea name="project_holder_intro" rows="4" id="project_holder_intro" class="form-control tinymce-txt" placeholder="{{ trans('misc.project_holder_intro') }}">@if( isset($project)) {{ $project->project_holder_intro }} @else {{ old('project_holder_intro') }} @endif</textarea>
              </div>
                           
              <!-- Alert -->
              <div class="alert alert-danger display-none" id="dangerAlert">
                <ul class="list-unstyled" id="showErrors"></ul>
              </div><!-- Alert -->
              @if(isset($id))
                 <input type="hidden" name="id"  value="{{ $id }}" > 
              @endif     
               <div class="box-footer">
                <hr />
                <div class="pull-right">
                  <button type="submit" id="saveSubmit" name="submit" value="saveSubmit" class="btn btn-lg btn-main custom-rounded">{{ trans('misc.save_submit_project') }}</button>
                </div>
                 <button type="submit" id="saveButton" name="submit" value="saveButton" class="btn btn-default btn-lg custom-rounded">@if(isset($project)) {{ trans('misc.update') }} @else {{ trans('admin.save') }} @endif </button>
               </div><!-- /.box-footer -->
             </form>

		</div><!-- /COL MD -->
		
		<div class="col-md-4">
			@include('users.navbar-edit')
      <hr/>
      @if(isset($projects))
      <div class="proposed-project-list well well-sm">
        <h4 class="text-center">{{ trans('misc.my_proposed_projects')}}</h4>
        <div class="table-responsive">
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Submitted</th>
                  <th>Validated</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach( $projects as $project)
                <tr>
                  <td>{{ substr(ucfirst($project->name),0,12) }}</td>
                  <td>@if($project->submitted){{ trans('misc.yes') }}@else{{ trans('misc.no') }}@endif</td>
                  <td>@if($project->submitted)@if($project->validated){{ trans('misc.yes') }}@else{{ trans('misc.no') }}@endif @endif</td>
                  <td><a href="{{ route('proposed-project.edit', $project->id )}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a></td>
                  
                </tr>
              @endforeach
              </tbody>
            </table>
        </div>
      </div>
      @endif
		</div>
		
 </div><!-- container -->
 
 <!-- container wrap-ui -->
@endsection

@section('javascript')
  <script src="{{ asset('public/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    
    function initTinymce() {
          tinymce.remove('.tinymce-txt');   
    tinymce.init({
      selector: '.tinymce-txt',
      relative_urls: false,
      resize: true,
      menubar:false,
        statusbar: false,
        forced_root_block : false,
        extended_valid_elements : "span[!class]", 
        //visualblocks_default_state: true,
      setup: function(editor){
                
          editor.on('change',function(){
            editor.save();
          });
       },   
      theme: 'modern',
      height: 150,
      plugins: [
        'advlist autolink autoresize lists link image charmap preview hr anchor pagebreak', //image
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save code contextmenu directionality', //
        'emoticons template paste textcolor colorpicker textpattern ' //imagetools
      ],
      toolbar1: 'undo redo | bold italic underline strikethrough charmap | bullist numlist  | link | image | media',
      image_advtab: true,
     });
     
    }

    initTinymce();  

  </script>
@endsection