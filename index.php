<?php
/**
 * Main template file.
 */
get_header(); ?>

<main id="primary" class="site-main" style="padding: 2rem; font-family: sans-serif;">
    <div class="container">
        <h1>WordPress Default Content</h1>
        <p>This text is rendered by the traditional WordPress `index.php` template.</p>
        
        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ccc;" />
        
        <h2>React Dynamic Section</h2>
        <p>The interactive component below is controlled entirely by React.</p>
        
        <!-- The React app will be injected into this div instead of overriding the whole page -->
        <div id="react-dashboard"></div>
    </div>
</main>

<?php get_footer(); ?>
