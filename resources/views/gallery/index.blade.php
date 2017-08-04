@extends('app')

@section('title') {{ trans('misc.media_gallery') }} @endsection

@section('css') <link href="{{ asset('public/css/gallery.css') }}" rel="stylesheet"> @endsection

@section('content') 
<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
  <div class="container wrap-jumbotron position-relative">
    <h2 class="title-site">{{ trans('misc.media_gallery') }}</h2>
  </div>
</div>

<div class="container margin-bottom-40" id="gallery-home">

 <div class="row">
   <div class="col-md-9">
      <ol class="breadcrumb bg-none">
      <li><i class="fa fa-home myicon-right"></i> Gallery home</li>
      </ol>
   </div>
 </div>

	<div class="row text-center" >
    <div class="col-md-3 col-md-offset-1">  
      <div class="thumbnail">
        <a href="{{ route('front-video-gallery')}}">
          <img src="{{ asset('public/gallery/cover/video.png')}}" alt="">
          
        </a>
      </div>
    </div>
    <div class="col-md-3 col-md-offset-1">  
      <div class="thumbnail">
        <a href="/w3images/lights.jpg">
          <img src="{{ asset('public/gallery/cover/audio.png')}}" alt="">
          
        </a>
      </div>
    </div>
    <div class="col-md-3 col-md-offset-1">  
      <div class="thumbnail">
        <a href="/w3images/lights.jpg">
          <img src="{{ asset('public/gallery/cover/image.png')}}" alt="">
         
        </a>
      </div>
    </div>
  </div>
 
 </div><!-- row -->
 
 <!-- container wrap-ui -->
@endsection

