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
             {{ trans('misc.video_gallery') }}
             <i class="fa fa-angle-right margin-separator"></i>
             <b>{{ $album->name }}</b>
           </small>
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
                        <figure class="">
                          <div  class="embed-responsive embed-responsive-4by3 bg-info">
                            <video class="" poster="{{ asset('public/gallery/video/thumbnail/'.$video->thumbnail) }}" controls preload="none">
                              <source src="{{ asset('public/gallery/video/'.$album->name.'/'.$video->url) }}" type="video/mp4">
                                <img src="{{ asset('public/gallery/video/thumbnail/'.$video->thumbnail) }}" alt="">
                                <p>Your browser can’t play this video, but you can download it:</p>
                            </video>
                          </div>
                          <figcaption class="figure__caption"><br>
                            <p class="well">{{ ucfirst($video->description) }}.</p>
                          </figcaption>
                        </figure>
                  </div>
                  <div class="col-md-2">
                    <div>
                      <form method="POST" action="{{route('videos.destroy',[$video->id])}}">
                        {{ method_field('DELETE')}}
                        {{ csrf_field()}}
                      
                      <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> {{ trans('admin.delete') }}</button>
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
