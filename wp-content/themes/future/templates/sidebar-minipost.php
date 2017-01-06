<?php 
	$args = array(
		'tag' => 'populaire',
		'posts_per_page' => 4
	);

	$popQuery = new WP_Query($args);
?>
<?php if ( $popQuery->have_posts()) : ?>
		
<section>
								<div class="mini-posts">
                                    
									<!-- Mini Post -->
										<article class="mini-post">
											<header>
											    <div class="title">
										<h2><a href="<?php the_permalink(); ?>"><?php the_title();?> 1</a></h2>
										<p><?php the_field('man') ?></p>
									</div>
												<time ><?php the_time('d-m-y'); ?></time>
												<a href="#" class="author"><span class="name"><?php the_author(); ?></span><img src="images/avatar.jpg" alt="" /></a>
											</header>
											<?php if ( has_post_thumbnail() &&  is_single() ) { ?>
								<a href="<?php the_permalink(); ?>">
				                <?php the_post_thumbnail('medium'); ?>
			                    </a>
								<?php }else{
									the_post_thumbnail('thumbnail');
								} ?>
								<?php if(!is_single()) {?>
                                 <p><?php the_excerpt();?>
	                          							
								</p>
								<?php } else {
									the_content();?>
								<?php } ?>
										</article>

								</div>
							</section>
<?php 
	endif;
	wp_reset_postdata();
?>