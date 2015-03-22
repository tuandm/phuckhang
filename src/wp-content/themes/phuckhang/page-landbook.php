<?php
/**
 * Author: Duc Duong
 * Template Name: Landbook Page
 * Description: This template used on pages which contains a shortcode of LandBook plugin that help forwading the current
 *   request to the CI front controller to process
 */

while (have_posts()) : the_post();
    the_content();
endwhile;