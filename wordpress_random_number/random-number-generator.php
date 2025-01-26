<?php
/*
Plugin Name: Random Number Generator
Description: A tool to assign random numbers to a list of names and display them in a sorted list. Use the shortcode [random_number_generator] to display the tool.
Version: 1.0
Author: Martin Graebing
*/

// Enqueue CSS and JavaScript
function rng_enqueue_scripts() {
    // Enqueue CSS
    wp_enqueue_style('rng-style', plugins_url('style.css', __FILE__));

    // Enqueue JavaScript
    wp_enqueue_script('rng-script', plugins_url('script.js', __FILE__), array('jquery'), null, true);

    // Localize script for nonce
    wp_localize_script('rng-script', 'rng_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('rng_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'rng_enqueue_scripts');

// Shortcode to display the tool
function rng_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div class="rng-container">
        <h1>Random Number Generator</h1>
        <div class="rng-explanation-box">
            <p>
                This tool assigns a random number to each name you enter. After displaying the results one by one, it shows a sorted list of names and their numbers in ascending order. Perfect for games, contests, or team assignments!
            </p>
        </div>
        <form id="rng-form">
            <label for="rng-names">Enter names (comma-separated):</label>
            <textarea id="rng-names" rows="4" required></textarea>
            <button type="submit">Start</button>
        </form>
        <div id="rng-output" class="rng-output"></div>
        <div id="rng-sorted-list" class="rng-sorted-list"></div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('random_number_generator', 'rng_shortcode');