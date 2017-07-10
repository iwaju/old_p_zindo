@if (count($errors)>0)
  <div class="alert alert-block alert-error fade in"id="error-block">
     
    <button type="button" class="close"data-dismiss="alert">×</button>

    <h4>Warning!</h4>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif