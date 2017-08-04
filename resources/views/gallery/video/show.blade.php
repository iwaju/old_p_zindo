@extends('app')
@section('css') <link href="{{ asset('public/css/gallery.css') }}" rel="stylesheet"> @endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper gallery-content">
        <!-- Content Header (Page header) -->
        <div class="jumbotron md index-header jumbotron_set jumbotron-cover">
          <div class="container wrap-jumbotron position-relative">
          </div>
        </div>
        <section class="content-header">
          <div class="row">
             <div class="col-md-9">
                <ol class="breadcrumb bg-none">
                <li><a href="{{route('chatter.home')}}"><i class="fa fa-home myicon-right"></i></a></li>
                <li class="active">{{ trans('misc.video_album') }}</li>
                </ol>
             </div>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container">
                              
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc.video_albums') }}</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach($albums as $album)
                    <li><a href="{{ route('video-show', ['id'=>$album->id]) }}"
                    @if( $current_album->id == $album->id) style="border-left: 3px solid #dd4b39"@endif ><i class="@if( $current_album->id == $album->id)fa fa-folder-open-o @else fa fa-folder-o @endif"></i> {{ ucfirst($album->name) }} <span class="label label-danger pull-right">{{ count($album->videos) }}</span></a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <div class="col-md-9 col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    @if($current_album)
                      {{ ucfirst($current_album->name) }}
                    @else
                      {{ trans('misc.no_album') }}
                    @endif
                  </h3>
                  <div class="box-tools pull-right">
                    <ul class="gal-menu">
                      
                    </ul>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    @forelse ($current_album->videos as $media)
                        <div class="col-sm-4 col-md-3">
                          <div class="thumbnail thumb-cont">
                              <img src="{{ asset('public/gallery/video/thumbnail'.'/'.$media->thumbnail) }}" alt="{{ $media->description }}" style="width:100%; height: 100%" class="img-responsive">
                              <a href="{{ route('video-show',['id'=>$media->id])}}" class="vid-links">
                                <i class="fa fa-youtube-play"></i>
                              </a>
                              <div class="vid-info">
                              <p class="small">{{ substr(ucfirst($media->description),0,16) }} ...</p>
                              
                            </div>
                            
                          </div>
                        </div>
                    @empty
                      @if($current_album)
                        <p class="col-md-6 col-md-offset-3">
                          {{ trans('misc.empty_album') }}.
                        </p>
                      @endif
                    @endforelse
                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>          
          
          <!-- Your Page Content Here -->
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection