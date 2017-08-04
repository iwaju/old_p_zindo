@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 class="small">
            <ol class="breadcrumb">
              <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
              <li class="active"><a href="{{ route('category-index') }}">{{{ trans('misc.categories') }}}</a></li>
            </ol>
          </h4>
        </section>
        <!-- Main content -->
        <section class="content">
         <div class="row">
          <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">{{ trans('misc.categories')}}</h3>
              <div class="box-tools pull-right">
                <a href="{{ route('forum-new') }}" class="btn btn-default" data-toggle="modal" data-target="#new-category"><i class="fa fa-plus-circle"></i> New</a>              
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-striped">
                <tbody>
                @php( $categories = DevDojo\Chatter\Models\Models::category()->all())

                  @foreach($categories as $k=>$category)
                  <tr>
                    <td><a href="pages/examples/invoice.html">{{$k+1}}</a></td>
                    <td>{{ ucfirst($category->name) }}</td>
                    <td>
                      <a href="{{route('category-update',['id'=>$category->id])}}" data-toggle="modal" data-target="#edit-category" class="btn btn-default btn-xs"> <i class="fa fa-pencil"></i></a>
                      <div style="display:inline-block;">
                        <form method="POST" action="{{route('category-destroy')}}" >
                          {{ csrf_field() }}{{ method_field('DELETE')}}<button type="submit" name="id" value="{{ $category->id }}" onclick="return confirm('Delete this category?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
                  <th>Status</th>
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

         <div class="modal fade" id="new-category" role="dialog">
             <div class="modal-dialog" style="margin-top: 12em;">
               <div class="modal-content">
               </div>
             </div>
         </div>
         <div class="modal fade" id="edit-category" role="dialog">
             <div class="modal-dialog" style="margin-top: 12em;">
               <div class="modal-content">
               </div>
             </div>
         </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

