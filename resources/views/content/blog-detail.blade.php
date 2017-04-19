@extends('layout.default')

@section('content')
<?php
//echo '<pre>'; print_r($blog); echo '</pre>';
?>
<div class="more-pages blog-wrap blog-detail">
	<div class="blog-menu">
		<ul>
			<li <?php if($title == 'Blog'){ echo 'class="active"';} ?>><a href="<?php echo url(); ?>/blog"><i class="fa fa-home"></i> Home</a></li>
                <?php 
				if(count($categories) > 0){
					foreach($categories as $val){
                ?>
						<li <?php if($cat_slug == $val->slug){ echo 'class="active"'; } ?>><a href="<?php echo url(); ?>/blog/<?php echo $val->slug; ?>"><?php echo $val->category_title; ?></ph></a></li>
                <?php 
					}
				}
                ?>
		</ul>
	</div>
	<style type="text/css">
 
#share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}
 
</style>
    <div class="container">
        <div class="blog-detail-inner">
            <div class="bd-top">
                <h1><?php echo $blog->title; ?></h1>
                <div class="blog-social1">
					<?php 
					$category = App\PageContent::categoryandslug($blog->id);
					$cat_slug = $cat_title = '';
					?>
                    <!--<span>BY <a href="">Zoe Manderson</a></span>-->
                    <?php
						if(count($category) > 0){
							$i=1;
							foreach($category as $value){
						 ?>
								<a href="<?php echo url(); ?>/blog/<?php echo $value->slug; ?>"><span><i class="fa fa-tag"></i><?php echo $value->category_title; ?></span></a>
						<?php 
							$i++;
							}
						}	
						?>
                    
                    <ul>
                        <li> <!-- Twitter -->
    <a href="https://twitter.com/share?url=<?php echo  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
    </a></li>
                        <li>   <!-- Facebook -->
    <a href="http://www.facebook.com/sharer.php?u=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
    </a></li>
                        <li>  <!-- Google+ -->
    <a href="https://plus.google.com/share?url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
    </a></li>
                    </ul>

                    <div class="clr"></div>
                </div>
                <?php if($blog->featured_image != ''){ ?>
						<div class="build-survey">
							<img src="<?php echo url(); ?>/uploads/featured_images/<?php echo $blog->featured_image; ?>" alt="survey">
						</div>
                <?php 
					}
                ?>
            </div>
            <div class="bd-btm">
                <?php echo $blog->description; ?>
              <!--  <div class="bd-testi">
                    <img src="img/bd-testi.jpg" alt="testi-image">
                    <h3>Zoe Manderson</h3>
                    <span>Marketing Manager at iBuildNew</span>
                    <p>Having just finished building her first new home, she lives and breaths all things home.</p>
                    <div class="clr"></div>
                </div>-->
            </div>
        </div>
        <!--<div class="fortingly">
                <i class="fa fa-comments"></i>
                <h2>Fortnightly news, promotions &amp; tips from iComparebuilders</h2>
                <form>
                      <input type="text" placeholder="Your email address" name="email">
                      <select>
                              <option>State</option>
                              <option>State2</option>
                      </select>
                      <input type="submit" value="Subscribe">
                      <div class="clr"></div>
                </form>
            </div>-->
			<?php if(!empty($related_content)) { 
			?>
            <div class="bd-similer">
            <h2>You might also like</h2>
            <div class="LA-main">
			<?php foreach($related_content as $cont_val) {  ?>
                <div class="LA-box">
				 <?php if($cont_val->featured_image != ''){ ?>
				  <?php $cat_arr =  App\BlogCategory::get_related_blog_catid($cont_val->id);  ?>
						   <a href="<?php echo url(); ?>/blog/<?php  echo $cat_arr->slug.'/'.$cont_val->slug; ?>"><img alt="image" src="<?php echo url(); ?>/uploads/featured_images/<?php echo $cont_val->featured_image; ?>"></a>
                <?php 
					} ?>
               <?php $related_cat =  App\BlogCategory::get_related_blog_cats($cont_val->id);  ?>
                    <span><?php echo $related_cat; ?></span>
                   <h2><a href="<?php echo url(); ?>/blog/<?php echo $cat_arr->slug.'/'.$cont_val->slug; ?>"><?php echo $cont_val->title; ?></a></h2>
                    <p><?php echo $description = substr($cont_val->description,0,127).'...';  ?></p>
                </div>
              <?php } ?>
                <div class="clr"></div>
            </div>
            </div>
			<?php } ?>
    </div>
</div>
@stop
