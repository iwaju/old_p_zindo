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
        <?php

            $albums = App\Models\MediaAlbum::where('type','video')->get();
           
        ?>
        	<div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('misc.video_albums') }}</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach($albums as $album)
                    <li><a href="{{route('video-show',['id'=>$album->id])}}"><i class="fa fa-folder-o"></i> {{ ucfirst($album->name) }} <span class="label label-danger pull-right">{{ count($album->videos) }}</span></a>
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
                  <h3 class="box-title">{{ trans('misc.video_album') }}</h3>
                  <div class="box-tools pull-right">
                    <ul class="gal-menu">
                      <li>
                       
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
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection