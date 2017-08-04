
<div class="col-md-8 col-md-offset-2">
<div class="thumbnail ">
    <img src="{{ asset('public/gallery/photo/'.$image->url) }}" alt="{{ $image->description }}" style="width:100%" class="img-responsive">
    <div class="caption">
      <p class="text-center">{{ ucfirst($image->description) }}.</p>
    </div>
</div>
</div>

