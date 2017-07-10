@extends('admin.layout')



@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            <small>
              {{ trans('admin.admin') }} 
              <i class="fa fa-angle-right margin-separator"></i> 
              {{ trans('misc.create_photo_album') }}
            </small>
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

          <div class="content">
            
            <div class="row">
    
          <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc.new_photo_album') }}</h3>
                </div><!-- /.box-header -->
               
               
               
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{route('albums.store')}}" enctype="multipart/form-data">
                  
                {{ csrf_field() }} 
      
                @include('errors.errors-forms')
                  <input type="hidden" name="media_type" value="{{ $media_type }}">
                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.name') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="{{ trans('admin.name') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.description') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ old('slug') }}" name="description" class="form-control" placeholder="{{ trans('admin.description') }}">
                      </div>
                    </div>

                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
                          
            </div><!-- /.row -->
            
          </div><!-- /.content -->
          
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
