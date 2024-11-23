<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
		<div class="bg-blue-200 text-white p-4">
			<h1 class="text-2xl font-bold">Hej Tailwind!</h1>
			<p class="mt-2">Tailwind CSS fungerar med Vite och WordPress.</p>
		</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer() ?>