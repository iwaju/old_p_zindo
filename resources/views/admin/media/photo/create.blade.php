@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 class="small">
            <ol class="breadcrumb">
              <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
              <li class=""><a href="{{route('photos-albums', ['id'=>$album_id])}}">{{ trans('misc.photo_album') }}</a></li>
              <li class="active">{{ trans('misc.add_image') }}  </li>
            </ol>
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="content">
            <div class="row">
          		<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc.new_photo_album') }}</h3>

                  <div class="pull-right box-tools">
                    <ul class="gal-menu">
                      
                      <li>
                        <a href="{{route('photos-albums', ['id'=>$album_id])}}" class="btn bt-link">
                          <i class="fa fa-arrow-left"> </i>
                          {{ trans('misc.back_to_album') }}
                        </a>

                      </li>
                      <li>
                        @includeIf('admin.media.form-link', [
                        'route'=>'albums.create', 'value'=>$media_type,
                        'text'=>'misc.new_album', 'fa'=>'fa-folder'
                        ])
                      </li>
                    </ul>
                  </div>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{route('photos.store')}}" enctype="multipart/form-data">
                  
                {{ csrf_field() }} 
      
                @include('errors.errors-forms')
                  
                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.description') }}</label>
                      <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="3" placeholder="Image description" >{{ old('description') }}</textarea>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('misc.select_album') }}</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="album" required>
                          <option value="">{{trans('misc.select_album')}}</option>
                          @foreach( $albums as $album )
                            <option value="{{ $album->id }}">{{ $album->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{trans('misc.select_image')}}</label>
                      <div class="col-sm-10">
                        <div class="btn btn-info box-file">
                          <input type="file" accept="image/*" name="image" required/>
                          <i class="glyphicon glyphicon-picture myicon-right"></i> {{ trans('misc.upload') }}
                        </div>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-footer">
                    <div class="pull-right">
                      <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                    </div>
                    <button type="reset" class="btn btn-danger">{{ trans('admin.reset') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
                          
            </div><!-- /.row -->
            
          </div><!-- /.content -->
          
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
