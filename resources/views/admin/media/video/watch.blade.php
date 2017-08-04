@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h4 class="small">
          <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
            <li><a href="{{route('videos.index')}}">{{ trans('misc.video_albums') }}</a></li>
            <li><a href="{{route('videos-albums',['id'=>$album->id])}}">{{ ucfirst($album->name) }}</a></li>
            <li class="active">{{ ucfirst($video->name) }}</li>
          </ol>
        </h4>
        </section>

        <!-- Main content -->
        <section class="content"> 
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $album->name }}</h3>
                <div class="box-tools pull-right">
                  <ul class="gal-menu">
                    <li>
                      <a href="{{route('videos-albums',['id'=>$album->id])}}" class="btn btn-box-tool">
                        <i class="fa fa-arrow-left"> </i>
                        {{ trans('misc.back_to_album') }}
                      </a>
                    </li>
                    <li>
                      @includeIf('admin.media.form-link', [
                      'route'=>'albums.create', 'value'=>$album->type,
                      'text'=>'misc.new_album', 'fa'=>'fa-folder'
                      ])
                    </li>
                    <li>
                      @includeIf('admin.media.form-link', [
                      'route'=>'videos.create', 'value'=>$album->id,
                      'text'=>'misc.gallery_upload', 'fa'=>'fa-upload'
                      ])
                    </li>
                  </ul>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">     
                    <div class="timeline-item">
                      <h3 class="timeline-header">{{ $video->title }}</h3>
                      <div class="timeline-body">
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                      </div>
                      <div class="timeline-footer">
                      <p  class="well well-sm  text-center bold">{{ ucfirst($video->description) }}.</p>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div>
                      <form method="POST" action="{{route('videos.destroy',[$video->id])}}">
                        {{ method_field('DELETE')}}
                        {{ csrf_field()}}
                      

                      <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Delete this video ?')"><i class="fa fa-trash-o"></i> {{ trans('admin.delete') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>        
          
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
