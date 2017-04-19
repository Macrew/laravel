@extends('layout.default')

@section('content')
<?php   if($terms[0]['featured_image'] == ''){
			$image = url()."/assets/images/privecy.jpg";
		}else{
			$image = url().'/uploads/featured_images/'.$terms[0]['featured_image'];
		}?>
<div class="more-pages">
	<div class="static_banner" style='background:url("<?php echo $image; ?>") no-repeat fixed 0 0 / cover'>
		<h2><?php echo $terms[0]['title']; ?></h2>
	</div>
    <div class="more-main">
    <div class="container">
        <div class="about-wrap" style='padding-top:40px;'>
            <?php echo $terms[0]['description']; ?>
        </div>
    </div>
    </div>
</div>
@stop
