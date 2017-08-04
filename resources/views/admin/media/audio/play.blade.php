@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h4 class="small">
          <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
            <li><a href="{{route('audios.index')}}">{{ trans('misc.audio_albums') }}</a></li>
            <li><a href="{{route('audios-albums',['id'=>$album->id])}}">{{ ucfirst($album->name) }}</a></li>
            <li class="active">{{ ucfirst($audio->title) }}</li>
          </ol>
        </h4>
        </section>

        <!-- Main content -->
        <section class="content"> 
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">{{ ucfirst($album->name) }}</h3>
                <div class="box-tools pull-right">
                  <ul class="gal-menu">
                    <li>
                      <a href="{{route('audios-albums',['id'=>$album->id])}}" class="btn btn-box-tool">
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
                      'route'=>'audios.create', 'value'=>$album->id,
                      'text'=>'misc.gallery_upload', 'fa'=>'fa-upload'
                      ])
                    </li>
                  </ul>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="thumbnail">
                      <audio controls>
                        <source src="{{ asset('public/gallery/audio/'.$album->name.'/'.$audio->url) }}" alt="{{ $audio->name }}" type="audio/mpeg">
                      Your browser does not support the audio element.
                      </audio>
                      <div class="caption text-center well">
                        <h4>{{ ucfirst($audio->title) }}</h4>
                        <p >{{ ucfirst($audio->description) }}.</p>
                      </div>
                    </div>  
                  </div>
                  <div class="col-md-2">
                    <div>
                      <form method="POST" action="{{route('audios.destroy',['id'=>$audio->id])}}">
                        {{ method_field('DELETE')}}
                        {{ csrf_field()}}
                      <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Delete this audio file ?')"><i class="fa fa-trash-o"></i> {{ trans('admin.delete') }}</button>
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
