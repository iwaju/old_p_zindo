<div class="div-bt-link">
	<form method="POST" action="{{route($route)}}">
	  {{ method_field('GET')}}<button type="submit" name="id_type" value="{{ $value }}" class="bt-link"><i class="fa {{ $fa }}"></i> {{ trans($text) }}</button>
	</form>
</div>