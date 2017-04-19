@extends('layout.default')

@section('content')
<?php
?>
<div class="more-pages blog-wrap">
<div class="blog-menu">
            <ul>
                <li <?php if($title == 'Blog'){ echo 'class="active"';} ?>><a href="<?php echo url(); ?>/blog"><i class="fa fa-home"></i> Home</a></li>
                <?php 
				if(count($categories) > 0){
					foreach($categories as $val){
                ?>
						<li <?php if($title == $val->slug){ echo 'class="active"'; } ?>><a href="<?php echo url(); ?>/blog/<?php echo $val->slug; ?>"><?php echo $val->category_title; ?></ph></a></li>
                <?php 
					}
				}
                ?>
            </ul>
        </div>
	<div class="static_banner" style='background:url("<?php echo url(); ?>/assets/images/blog.jpg") no-repeat fixed 0 0 / cover'>
		<h2>Latest Articles</h2>
	</div>
    <div class="container">
        <div class="latest-articles">
			<?php 
			if($title == 'Blog'){
			?>
            <?php 
            }
            ?>
            <div class="LA-main">
				 <?php 
				if(count($blog) > 0){
					$cat_slug = $cat_title = $cat_count = '';
					foreach($blog as $val){
						$description = '';
						if($val->description != ''){
							if(strlen($val->description) > 127){
								$description = substr($val->description,0,127).'...';
							}
							else{
								$description = $blog->description;
							}
						}else{
							$description = '';
						}
						$category = App\PageContent::categoryandslug($val->id);
						$cat_slug = $cat_title = '';
				?>
                <div class="LA-box">
					<?php if($val->featured_image == ''){ ?>
                    <a href="<?php echo url(); ?>/blog/<?php echo $val->cat_slug.'/'.$val->slug; ?>"><img src="{{ URL::asset('assets/img/p5.png') }}" alt="image"></a>
                    <?php 
							}else{ ?>
								<a href="<?php echo url(); ?>/blog/<?php echo $val->cat_slug.'/'.$val->slug; ?>"><img src="<?php echo url(); ?>/uploads/featured_images/<?php echo $val->featured_image; ?>" alt="image"></a>
					<?php	}
                    ?>
                    <span>
						<?php
						$count = count($category);
						if(count($category) > 0){
							$i=1;
							$comma = ',';
							foreach($category as $value){
								if($i == $count){ $comma = ''; }
						 ?>
								<a href="<?php echo url(); ?>/blog/<?php echo $value->slug; ?>"><?php echo $value->category_title; ?></a><?php echo $comma; ?>
						<?php 
							$i++;
							}
						}	
						?>
                    </span>
                    <h2><a href="<?php echo url(); ?>/blog/<?php echo $val->cat_slug.'/'.$val->slug; ?>"><?php echo $val->title; ?></a></h2>
                    <p><?php echo $description; ?></p>
                </div>
                <?php
					}
				}else{ echo '<div style="font-size: 30px;font-weight: bold;padding: 57px;text-align: center;width: 100%;">Sorry, no blog found.</div>'; }
                ?>
                <div class="clr"></div>
                <div class='paginate_property'>
					{!! $blog->render() !!}
				</div>
            </div>
            <!--<div class="fortingly">
                <i class="fa fa-comments"></i>
                <h2>Fortnightly news, promotions & tips from iBuildNew</h2>
                <form>
                      <input type="text" name="email" placeholder="Your email address">
                      <select>
                              <option>State</option>
                              <option>State2</option>
                      </select>
                      <input type="submit" value="Subscribe">
                      <div class="clr"></div>
                </form>
            </div>-->
           <!-- <div class="LA-main">
                <div class="LA-box">
                    <a href=""><img src="img/p5.png" alt="image"></a>
                    <span>Tips & Guides</span>
                    <h2>14 Tips For An Energy Efficient New Home</h2>
                    <p>An energy efficient home reduces your bills, leaving you extra money to pay off that mortgage faster – plus there’s…</p>
                </div>
                <div class="LA-box">
                    <a href=""><img src="img/p5.png" alt="image"></a>
                    <span>Tips & Guides</span>
                    <h2>14 Tips For An Energy Efficient New Home</h2>
                    <p>An energy efficient home reduces your bills, leaving you extra money to pay off that mortgage faster – plus there’s…</p>
                </div>
                
                <div class="LA-box">
                    <a href=""><img src="img/p5.png" alt="image"></a>
                    <span>Tips & Guides</span>
                    <h2>14 Tips For An Energy Efficient New Home</h2>
                    <p>An energy efficient home reduces your bills, leaving you extra money to pay off that mortgage faster – plus there’s…</p>
                </div>
                <div class="clr"></div>
            </div>-->
        </div>
    </div>
</div>
@stop
