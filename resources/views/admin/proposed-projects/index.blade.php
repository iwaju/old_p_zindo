@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 class="small">
            <ol class="breadcrumb">
              <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
              <li class="active">{{{ trans('misc.proposed_projects_list') }}}</li>
            </ol>
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">
			@if (Session::has('notification'))
			<div class="alert alert-success btn-sm alert-fonts" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         		{{ trans(Session::get('notification')) }}
         		</div>
         	@endif
         <div class="row">
          <div class="col-md-8">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">{{ trans('misc.proposed_projects')}}</h3>
              <div class="box-tools pull-right">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-striped">
                <tbody>
                
                  @foreach($projects as $project)
                  <tr>
                    <td><a href="#">{{$loop->index + 1}}</a></td>
                    <td>{{ ucfirst($project->name) }}</td>
                    <td>@if($project->validated){{ trans('misc.yes') }}@else{{ trans('misc.no') }}@endif</td>
                    <td>
                      <a href="{{ route('proposed-projects-show',['id'=>$project->id ])}}" data-toggle="modal" data-target="#show-project" class="btn btn-default btn-xs"> <i class="fa fa-eye"></i></a>
                      <div style="display:inline-block;">
                        <form method="POST" action="{{route('proposed-projects-del')}}" >
                          {{ csrf_field() }}{{ method_field('DELETE')}}<button type="submit" name="id" value="{{ $project->id }}" onclick="return confirm('Delete this project?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                    <td>
                      <div style="display:inline-block;">
                    	<form method="POST" action="{{route('proposed-projects-validate')}}" >
                    	    {{ csrf_field() }}
                    	    <input type="hidden" name="validate" value="{{ $project->id }}">
                    	    <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Validate this project?')"><i class="fa fa-thumbs-o-up"></i></button>
                    	</form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
              <thead>
                <tr>
                  <th style="width: 10px">N°</th>
                  <th>Name</th>
                  <th>Validated</th>
                  <th>Action</th>
                  <th>validate</th>
                </tr>
              </thead>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              
            </div>
          </div>
          </div>
         </div>

         <div class="modal fade" id="show-project" role="dialog">
             <div class="modal-dialog" >
               <div class="modal-content">
               
               </div>
             </div>
         </div>
         <div class="modal fade" id="edit-project" role="dialog">
             <div class="modal-dialog" style="margin-top: 12em;">
               <div class="modal-content">
               </div>
             </div>
         </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

