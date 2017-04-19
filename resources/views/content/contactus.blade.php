@extends('layout.default')

@section('content')
<?php 
//echo '<pre>'; print_r($contact);die;
if($contact[0]['featured_image'] == ''){
			$image = url()."/assets/img/contact.jpg";
		}else{
			$image = url().'/uploads/featured_images/'.$contact[0]['featured_image'];
		}?>
<div class="more-pages">
    <div class="static_banner" style='background:url("<?php echo $image; ?>") no-repeat fixed 0 0 / cover'>
		<h2><?php echo $contact[0]['title']; ?></h2>
	</div>
    <div class="more-main">
    <div class="container">
        <div class="contact-wrap">
			<?php echo $contact[0]['description']; ?>
            <div class="clr"></div>
        </div>
    </div>
    </div>
</div>

@stop
