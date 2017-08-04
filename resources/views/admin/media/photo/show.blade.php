@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 class="small">
            <ol class="breadcrumb">
              <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> {{ trans('admin.admin') }}</a></li>
              <li><a href="{{route('photos.index')}}">{{ trans('admin.admin') }}</a></li>
              <li class="active">{{ ucfirst($current_album->name) }}</li>
            </ol>
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">
                              
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc.photo_albums') }}</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach($albums as $album)
                    <li><a href="{{ route('photos-albums', ['id'=>$album->id]) }}"
                    @if( $current_album->id == $album->id) style="border-left: 3px solid #dd4b39"@endif ><i class="@if( $current_album->id == $album->id)fa fa-folder-open-o @else fa fa-folder-o @endif"></i> {{ ucfirst($album->name) }} <span class="label label-danger pull-right">{{ count($album->images) }}</span></a>
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
                      <li>
                         <a href="{{route('albums.edit', ['id'=>$current_album->id])}}" class="fa fa-pencil bt-link"> {{ trans('misc.edit_album')}}</a>
                      </li>
                      <li>
                      <div class="div-bt-link">
                        <form method="POST" action="{{route('albums.destroy',['id'=>$current_album->id])}}">
                          {{ method_field('DELETE')}}
                          {{ csrf_field()}}
                        <button type="submit" class="bt-link" onclick="return confirm('Delete this album?')"><i class="fa fa-trash-o" ></i> {{ trans('admin.delete') }}</button>
                        </form>
                        </div>
                      </li>
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
                    @forelse ($current_album->images as $k=>$image)
                        <div class="col-sm-4 col-md-3">
                          <div class="thumbnail thumb-cont">
                            <img src="{{ asset('public/gallery/photo/'.$image->url) }}" alt="{{ $image->description }}" style="width:100%; height: 100%" class="img-responsive">
                            <a href="{{ route('photos.show',['id'=>$image->id])}}" class="thum-links" data-toggle="modal" data-target="#photoModal-{{ $k }}">
                              <i class="fa fa-plus-circle"></i>
                            </a>
                            <div class="thumb-info">
                              <p class="small">{{ substr(ucfirst($image->description),0,16) }} ...</p>
                              <div class="btn-del">
                                <form method="POST" action="{{route('photos.destroy',['id'=>$image->id])}}">
                                  {{ method_field('DELETE')}}{{ csrf_field()}}
                                <button type="submit" class="btn btn-sm"onclick="return confirm('Delete this photo ?')" onclick="return confirm('Delete this album?')"><i class="fa fa-trash-o"></i></button>
                                </form>
                              </div>
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
                    <div>
                      @foreach ($current_album->images as $k=>$image)
                        <div class="modal fade" id="photoModal-{{ $k }}" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content" style="">

                              </div>
                            </div>
                        </div>
                      @endforeach
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>          
          
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection