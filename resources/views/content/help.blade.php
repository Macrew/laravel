@extends('layout.default')

@section('content')
<?php   if($about[0]['featured_image'] == ''){
			$image = url()."/assets/img/help.jpg";
		}else{
			$image = url().'/uploads/featured_images/'.$about[0]['featured_image'];
		}?>
<div class="more-pages">
	<div class="static_banner" style='background:url("<?php echo $image; ?>") no-repeat fixed 0 0 / cover'>
		<h2><?php echo $about[0]['title']; ?></h2>
	</div>
    <!--<div class="page-label">
        <ul>
            <li><a href="{{ url('aboutus') }}" <?php //if($about[0]['slug'] == 'about-us'){ echo "class='active'"; } ?> >About Us</a></li>
            <li><a href="{{ url('ourstory') }}" <?php //if($about[0]['slug'] == 'our-story'){ echo "class='active'"; } ?> >Our Story</a></li>
            <li><a href="{{ url('whyicomparebuilders') }}" <?php //if($about[0]['slug'] == 'why-icomparebuilders'){ echo "class='active'"; } ?> >Why iCompareBuilders</a></li>
        </ul>
    </div>-->
    <div class="more-main">
    <div class="container">
        <div class="about-wrap" style='padding-top:40px;'>
            <?php echo $about[0]['description']; ?>
        </div>
    </div>
    </div>
</div>
@stop
