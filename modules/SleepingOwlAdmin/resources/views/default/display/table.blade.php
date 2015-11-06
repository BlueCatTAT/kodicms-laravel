@if ( ! empty($title))
	<div class="row">
		<div class="col-lg-12">
			<h2 style="margin-top:0;"><small>{{ $title }}</small></h2>
		</div>
	</div>
@endif
@if ($creatable)
	<a class="btn btn-primary" href="{{ $createUrl }}"><i class="fa fa-plus"></i> {{ trans('sleepingowladmin::core.table.new-entry') }}</a>
@endif
<div class="pull-right tableActions">
	@foreach ($actions as $action)
		{!! $action !!}
	@endforeach
</div>
<table class="table table-striped">
	<thead>
		<tr>
			@foreach ($columns as $column)
				{!! $column->getHeader() !!}
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach ($collection as $model)
			<tr>
				@foreach ($columns as $column)
					<?php
						$column->setModel($model);
					?>
					{!! $column !!}
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>
