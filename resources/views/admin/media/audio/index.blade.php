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
             {{ trans('misc.audio_album') }}
            </small>
          </h4>
     
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ $media_type }} Albums</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach($albums as $album)
                    <li><a href="{{ route('audios-albums', ['id'=>$album->id]) }}"><i class="fa fa-folder-o"></i> {{ ucfirst($album->name) }} <span class="label label-danger pull-right">{{ count( $album->audios ) }}</span></a>
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
                  <h3 class="box-title">{{ trans('misc.audio_album') }}</h3>
                  <div class="box-tools pull-right">
                    <ul class="gal-menu">
                      <li>
                        @includeIf('admin.media.form-link', [
                        'route'=>'albums.create', 'value'=>$media_type,
                        'text'=>'misc.new_album', 'fa'=>'fa-folder'
                        ])
                      </li>
                    </ul>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <p class="col-md-6 col-md-offset-3">
                      {{ ucfirst(trans('misc.empty_select_album')) }}.
                    </p>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>        	
        	
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection