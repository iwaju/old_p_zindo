<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('misc.a_proposed_project') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="mailbox-read-info">
            <h3>{{ ucfirst($project->name) }}</h3>
            <h5>From: {{ ucfirst($user->email) }}
            <span class="mailbox-read-time pull-right">{{ ucfirst($project->created_at) }}</span></h5>
        </div>
        <div class="mailbox-controls with-border text-center">
            &nbsp;
        </div>
        <div class="mailbox-read-message">
        	<h4>{{ trans('misc.project_details')}}</h4>
            <p> 
				<strong>{{ trans('misc.project_name')}}:</strong> {{ ucfirst($project->name) }}<br>
				<strong>{{ trans('misc.country')}}:</strong> {{ ucfirst($project->country) }}<br>
				<strong>{{ trans('misc.town')}}:</strong> {{ ucfirst($project->town) }}<br>
				<strong>{{ trans('misc.amount_to_collect')}}:</strong> {{$settings->currency_symbol}} {{ ucfirst($project->amount) }}<br>
				<strong>{{ trans('misc.campaign_duration')}}:</strong> {{ ucfirst($project->campaign_duration) }}<br>
            </p>
            <div class="mailbox-controls with-border text-center">
               &nbsp;
            </div>
            <h4>{{ trans('misc.project_description')}}</h4>
            <p>{{ ucfirst($project->description) }}</p>
            <div class="divider"></div>

            <h4>{{ trans('misc.project_counterparts') }}</h4>
            <p>{{ ucfirst($project->counterparts) }}</p>
            <div class="divider"></div>

            <h4>{{ trans('misc.project_holder_intro') }}</h4>
            <p>{{ ucfirst($project->project_holder_intro) }}</p>
            <div class="divider"></div>
        </div>
    </div>
	<!-- /.box-body -->
	<div class="box-footer">
	    
	</div>
      <!-- /.box-footer -->
</div>