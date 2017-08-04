<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">New category</h3>
      
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" role="form" method="POST" action="{{ route('forum-new')}}">
    	{{ csrf_field() }}
      <div class="box-body">
        <div class="form-group">
          <label for="category" class="col-sm-2 control-label">{{ trans('misc.name') }}</label>

          <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="category" placeholder="Category name">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{ route('category-index') }}" class="btn btn-default btn-md" data-dismiss="modal"> {{ trans('misc.cancel') }}</a>
        <button type="submit" class="btn btn-success pull-right">Create</button>
      </div>
      <!-- /.box-footer -->
    </form>
</div>