@extends('layout.default')

@section('content')

	<div class="static_banner" style='background:url("<?php echo url(); ?>/assets/images/builder.jpg") no-repeat fixed 0 0 / cover'>
		<h2>Our Builders</h2>
	</div> 
	<div class="container2">
        <div class="best-bulid-wrap">
            <div class="best-bulid">
                   <?php if(!empty($builder[0]['description'])) {
							echo $builder[0]['description'];
							}
			
				   ?>
           </div>
       </div>
       <div class="discover-builders">
           <h2>Discover our builders</h2>
		   

		   
		   
           <ul class='builders_click'>
			   <?php 
			   $i=0;
			    $state = Session::get('header_state'); 
				foreach($states as $val) {
					
					if(!empty($state_name)) {
						if($val->state_name == $state_name) {
						$cls = 'active1';
						} 
					 else {
						$cls = '';
						}
				
					} 
					else if(!empty($state)) {
					 if($state == $val->state_name)  {
					$cls = 'active1';
					 } 
					 else {
						$cls = '';
						}
					} else {
					if($i == 0) { $cls = 'active1'; } else {$cls = ''; }
					
					}
					
					
			   ?>
					<li class='discovers <?php echo $cls; ?>' rel='<?php echo $val->state_name; ?>'><a href="javascript:void(0);" ><?php echo $val->state_name; ?></a></li>
               <?php 
		$i++;  }
               ?>
           </ul>
       </div>
       <div class="major-builder">
		<?php if(count($builderdetail['featured']) > 0) {
			$i=0;
			foreach($builderdetail['featured'] as $key => $val) {
				//$cls = '';
				//if($i == 0) { $cls = 'active1'; }
				
					if(!empty($state_name)) {
						if($key == $state_name) {
						$cls = 'active1';
						} 
					 else {
						$cls = '';
						}
				
					} 
					
					else if(!empty($state)) {
					 if($state == $key)  {
					$cls = 'active1';
					 } 
					 else {
						$cls = '';
						}
					} else {
					if($i == 0) { $cls = 'active1'; } else {$cls = ''; }
					
					}
				
				?>
				
			   <div class="major-builder-box-wrap <?php echo $key; ?> <?php echo $cls; ?> inactive">
				<h1>Featured Building Partners</h1>	
		<?php foreach($val as $keys => $value) { ?>
						<div class="major-build-con">
							<div class="major-builder-box">
							<div class="major_builder_links">
								<a href='<?php echo url() ?>/builder-detail/<?php echo $value->builder_id; ?>'><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $value->logo; ?>" class= 'img-responsive' alt="image"></a>
								<a href='<?php echo url() ?>/builder-detail/<?php echo $value->builder_id; ?>'>View Profile</a>
								</div>
							</div>
								
						</div>
				<?php } ?>
				   <div class="clr"></div>
			   </div>
	<?php 		$i++;
			}
		} ?>
       </div>
       <div class="major-builder extent-builder">
		<?php if(count($builderdetail['extended']) > 0) {
			$i=0;
			foreach($builderdetail['extended'] as $key => $val) { 
				if(!empty($state_name)) {
						if($key == $state_name) {
						$cls = 'active1';
						} 
					 else {
						$cls = '';
						}
				
					} 
					
					else if(!empty($state)) {
					 if($state == $key)  {
					$cls = 'active1';
					 } 
					 else {
						$cls = '';
						}
					} else {
					if($i == 0) { $cls = 'active1'; } else {$cls = ''; }
					
					}
				if(count($val) > 0) {
					
					?>
				   <div class="major-builder-box-wrap <?php echo $key; ?> <?php echo $cls; ?> inactive">
					<h1>Listed Building Partners</h1>
					<?php foreach($val as $key => $value) {  ?>
							<div class="major-build-con">
								<div class="major-builder-box">
								<div class="major_builder_links">
									<a href='<?php echo url() ?>/builder-detail/<?php echo $value->builder_id; ?>'>
									
									<?php 
									if(!empty($value->logo)) {
									?>
									<img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $value->logo; ?>" class= 'img-responsive' alt="image" >
									<?php } else { ?>
									<img src="<?php echo url(); ?>/assets/img/no-image.jpg" class= 'img-responsive' alt="image" >
									<?php } ?>
									</a>
									<a href='<?php echo url() ?>/builder-detail/<?php echo $value->builder_id; ?>'>View Profile</a>
									</div>
								</div>
								
							</div>
					<?php } ?>
					   <div class="clr"></div>
				   </div>
		<?php 		$i++;
				}
			}
		} ?>
	</div>
		
</div>
<?php //echo '<pre>'; print_r($builderdetail); echo '</pre>'; ?>
<script>
	$('.builders_click').find('li').click(function(){
		var rel = $(this).attr('rel');
		$('.discovers').removeClass('active1');
		$(this).addClass('active1');
		$('.major-builder-box-wrap').removeClass('active1');
		$('.'+rel).addClass('active1');
	});
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
