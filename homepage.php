<?php 
/**
Template Name: Home
*/
get_header();
	if(function_exists('dgibuilder_ourteam')){
       dgibuilder_ourteam();
    }
	if(function_exists('dgibuilder_welcome')){
       dgibuilder_welcome();
    }
	if(function_exists('dgibuilder_services')){
       dgibuilder_services();
    }
	if(function_exists('dgibuilder_about')){
       dgibuilder_about();
    }
	
	if(function_exists('dgibuilder_portfolio')){
       dgibuilder_portfolio();
    }
	if(function_exists('dgibuilder_testimonial')){
       dgibuilder_testimonial();
    }
	if(function_exists('dgibuilder_blog')){
       dgibuilder_blog();
    }
	if(function_exists('dgibuilder_more_infor')){
       dgibuilder_more_infor();
    }
	
get_footer(); ?> 