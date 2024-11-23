<!-- header.php -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>"> <!-- Ex. UTF8 -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
</head>

<body>
	<header>
		<h1><?php wp_title("") ?></h1> <!-- Testa att ta bort "" inuti wp_title("") och se vad som händer. Lägg till <h1> -->
		<nav>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'primary-menu', // Kopplar till den meny som registrerades
				'container' => false,               // Tar bort standard-wrapper (valfritt)
				'menu_class' => 'my-menu',          // CSS-klass för menylistan
			));
			?>
		</nav>
	</header>