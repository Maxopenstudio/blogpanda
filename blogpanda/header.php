<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blogpanda
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<header class="header-container">
    <div class="header-background">
        <!-- You can place the background image URL here -->
    </div>

</header>
<div class="container">
    <div class="row"><div class="logo">
            <?php 	the_custom_logo(); ?>
            <h1>LEAD PANDA</h1>
            <p>На сайті с 2023 року</p>
        </div></div>

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


