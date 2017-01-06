						<!-- Post -->
							<?php if (have_posts() ) :
								while (have_posts()) :the_post();
							?>
							<article class="post">
								<header>
									<div class="title">
										<h2><a href="<?php the_permalink(); ?>"><?php the_title();?> 1</a></h2>
										<p><?php the_field('man') ?></p>
									</div>
									<div class="meta">
										<time ><?php the_time('d-m-y'); ?></time>
										<a href="#" class="author"><span class="name"><?php the_author(); ?></span><img src="images/avatar.jpg" alt="" /></a>
									    <?php the_tags( 'Etiquettes: ', ', ', '<br />' ); ?> 
									</div>
								</header>
								<?php if ( has_post_thumbnail() &&  is_single() ) { ?>
								<a href="<?php the_permalink(); ?>">
				                <?php the_post_thumbnail('medium'); ?>
			                    </a>
								<?php }else{
									the_post_thumbnail('large');
								} ?>
								<?php if(!is_single()) {?>
                                 <p><?php the_excerpt();?>
								</p>
								<?php } else {
									the_content();
									comments_template();
									?>
									<li><a href="" > <?php next_post_link('%link', 'Article Suivant') ?></a></li>
								    <li><a href="#" ><?php previous_post_link('%link', 'Article Précedent')?></a></li>
								<?php } ?>
								
								<footer>
								<?php if(!is_single()) {?>
									<ul class="actions">
										<li><a href="<?php the_permalink(); ?>" class="button big">Continue Reading</a></li>
									</ul>
									<?php }?>
									<ul class="stats">
										<?php $categories = get_the_category();?>
					                    <li><a href="<?php echo get_category_link($categories[0]->term_id); ?>"><?php echo $categories[0]->name; ?></a></li>
										<li><a href="#" class="icon fa-heart">28</a></li>
										<li><a href="#" class="icon fa-comment"><?php get_comments_number(); ?></a></li>
									</ul>
								</footer>
							</article>
	<?php endwhile; endif ?>
						<!-- Post -->
				
