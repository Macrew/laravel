@extends('layout.default')

@section('content')
<div class="more-pages">
	<div class="static_banner" style='background:url("<?php echo url(); ?>/assets/images/testimonial.jpg") no-repeat fixed 0 0 / cover'>
		<h2>TESTIMONIAL</h2>
	</div>
    <div class="more-main">
    <div class="container">
        <div class="about-wrap testi-wrap">
            <div class="testi-left">
				<?php 
				if(count($testimonials) > 0){
					foreach($testimonials as $val){
						?>
						<div class="testi-box">
							<p><?php echo $val->description; ?></p>
							<span><?php echo $val->created_by; ?></span>
							<span style="color:#2FCBD6;"><?php echo $val->state_company; ?></span>
						</div>
					   <?php 
					}
				}
               ?>
            </div>
            <div class="testi-right">
                <div class="call-us">
                    <p>Call our free and independent home building consultant now</p>
                    <div class="rt_phone">
						<img src="{{ URL::asset('assets/images/phone.png') }}" />
						<h1>1800 824 823</h1>
					</div>
                </div>
                  <?php if(!empty($ads_arr)) { ?>
        <div class="add_model"><!--add section!-->
		<?php  foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your Free Building Guide when you Enquire</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        </div><!--add section!-->
        <?php } ?>
              <a href="<?php echo url(); ?>/property/search-property" class="see_all">Take our quick tour &nbsp;<i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    </div>
</div>
@stop
