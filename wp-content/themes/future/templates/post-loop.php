						<!-- Post -->
							<?php if (have_posts() ) :
								while (have_posts()) :the_post();
							?>
							<article class="post">
								<header>
									<div class="title">
										<h2><a href="<?php the_permalink(); ?>"><?php the_title();?> 1</a></h2>
										<p><?php the_title_attribute(); ?></p>
									</div>
									<div class="meta">
										<time ><?php the_time('d-m-y'); ?></time>
										<a href="#" class="author"><span class="name"><?php the_author(); ?></span><img src="images/avatar.jpg" alt="" /></a>
									</div>
								</header>
								<?php if ( has_post_thumbnail() &&  is_single() ) { ?>
								<a href="<?php the_permalink(); ?>">
				                <?php the_post_thumbnail('thumbnail'); ?>
			                    </a>
								<?php }else{
									the_post_thumbnail('large');
								} ?>
								<?php if(is_home()) {?>
                                 <p><?php the_excerpt();?>
	                          							
								</p>
								<?php } else {
									the_content();
								} ?>
								
								<footer>
								<?php if(is_home()) {?>
									<ul class="actions">
										<li><a href="<?php the_permalink(); ?>" class="button big">Continue Reading</a></li>
									</ul>
									<?php }?>
									<ul class="stats">
										<li><a href="#"> <?php the_category( ', ' ); ?></a></li>
										<li><a href="#" class="icon fa-heart">28</a></li>
										<li><a href="#" class="icon fa-comment">128</a></li>
									</ul>
								</footer>
							</article>
	<?php endwhile; endif ?>
						<!-- Post -->
				
