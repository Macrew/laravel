@extends('layout.default')

@section('content')	

<div class="message">
 <div class="en-now-wrap">
    <div class="en-main">

				<?php if(!empty($_REQUEST['success'])) { if($_REQUEST['success'] == 'true') { ?>
					<h1>We've sent your enquiry</h1>
										<p class="content-page--success__subtitle">You can expect a phone call from the builder(s) in the next two business days.</p>
										<p class="content-page--success__subtitle">You can always go back to your Saved Homes at any time and send enquiries to other builders.</p>

			
					<p><a href="<?php echo url(); ?>/favourites/filter" class="btn btn-light-blue btn-block">Go back to Saved Homes</a></p>
			<?php } else {  ?>
			<h1 style="text-align:center;">Invalid User</h1>
			<?php } } else { ?>
			<h1 style="text-align:center;">Invalid User</h1>
			<?php } ?>
			</div>

</div>
</div>
@stop