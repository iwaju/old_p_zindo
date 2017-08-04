@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 class="small">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
              <li class="">{{ trans('misc'.$current_album->type.'_album') }}</li>
              <li class="active">{{ $current_album->name }}</li>
            </ol>
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">
                              
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc'.$album->type.'_albums') }}</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach($albums as $album)
                    <li><a href="{{ route('photos-albums', ['id'=>$album->id]) }}"
                    @if( $current_album->id == $album->id) style="border-left: 3px solid #dd4b39"@endif ><i class="@if( $current_album->id == $album->id)fa fa-folder-open-o @else fa fa-folder-o @endif"></i> {{ ucfirst($album->name) }} <span class="label label-danger pull-right">{{ count($album->$current_album->type.'s') }}</span></a>
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
                      {{ $current_album->name }}
                    @else
                      {{ trans('misc.no_album') }}
                    @endif
                  </h3>
                  <div class="box-tools pull-right">
                    <ul class="gal-menu">
                      <li>
                        @includeIf('admin.media.form-link', [
                        'route'=>'albums.create', 'value'=>$current_album->type,
                        'text'=>'misc.new_album', 'fa'=>'fa-folder'
                        ])
                      </li>
                      <li>
                        @includeIf('admin.media.form-link', [
                        'route'=>$current_album->type.'s.create', 'value'=>$current_album->id,
                        'text'=>'misc.gallery_upload', 'fa'=>'fa-upload'
                        ])
                      </li>
                    </ul>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    @forelse ($medias as $media)
                        <div class="col-sm-4 col-md-3">
                          <div class="thumbnail">
                            <a href="{{ route($current_album->type.'s.show',['id'=>$media->id])}}">
                              <img src="{{ asset('public/gallery/photo/'.$current_album->name.'/'.$media->url) }}" alt="{{ $media->description }}" style="width:100%;min-height:88px; " class="img-responsive">
                              <div class="caption">
                                <p class="text-center">{{ ucfirst($media->description) }}.</p>
                              </div>
                            </a>
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

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection