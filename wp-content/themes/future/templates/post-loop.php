						<!-- Post -->
							<?php if (have_posts() ) :
								while (have_posts()) :the_post();
							?>
							<article class="post">
								<header>
									<div class="title">
										<h2><a href="<?php the_permalink(); ?>"><?php the_title();?> 1</a></h2>
										<p>Lorem ipsum dolor amet nullam consequat etiam feugiat</p>
									</div>
									<div class="meta">
										<time ><?php the_time('d-m-y'); ?></time>
										<a href="#" class="author"><span class="name"><?php the_author(); ?></span><img src="images/avatar.jpg" alt="" /></a>
									</div>
								</header>
								<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
								<p><?php the_excerpt(); ?></p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button big">Continue Reading</a></li>
									</ul>
									<ul class="stats">
										<li><a href="#">General</a></li>
										<li><a href="#" class="icon fa-heart">28</a></li>
										<li><a href="#" class="icon fa-comment">128</a></li>
									</ul>
								</footer>
							</article>
	<?php endwhile; endif ?>
						<!-- Post -->
				
