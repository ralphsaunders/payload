<?php
    $this->load->helper( 'form' );
?>

<section class="pl-wrap">

    <aside class="pl-sidebar">
    </aside>
    <article class="pl-main">
        <h1><?php echo $title; ?></h1>

        <p>Before you can get going we need some information about you and the blog you're setting up.</p>
    </article>

    <br class="clear">

    <?php echo form_open( 'setup' ); ?>

    <aside class="pl-generic-sidebar">
        <p>
           <?php echo form_label( "This will be displayed on the homepage of your blog.", 'blog_name' ); ?>
        </p>
    </aside>
    <article class="pl-main">
        <h4>Your Blog's Name</h4>
        <?php echo form_input( 'blog_name', "John Doe's Blog" ); ?>
    </article>

    <br class="clear">

    <aside class="pl-generic-sidebar">
        <p></p>
    </aside>
    <article class="pl-main">
        <h4>Your Name</h4>
        <?php echo form_input( 'users_name', "John Doe" ); ?>
    </article>

    <br class="clear">

    <aside class="pl-generic-sidebar">
        <p>
            <?php echo form_label( "Your bio will be displayed beside your posts on the homepage of your blog.", 'bio' ); ?>
        </p>
    </aside>
    <article class="pl-main">
        <h4>Your Bio</h4>
        <?php echo form_textarea( 'bio', "" ); ?>
    </article>

    <br class="clear">

    <aside class="pl-generic-sidebar">
        <p>
            <?php echo form_label( "Your email will be used to verify changes to the blog, afterall you don't want just anybody writing your bio.", 'email' ); ?>
        </p>
    </aside>
    <article class="pl-main">
        <h4>Your Email</h4>
        <?php echo form_input( 'email', "email@example.com" ); ?>
    </article>

    <br class="clear">

    <aside class="pl-generic-sidebar">
        <p>
            <?php echo form_label( "This field is optional, but if you do have a twitter username it'll be placed under your bio on the homepage", 'twitter' ); ?>
        </p>
    </aside>
    <article class="pl-main">
        <h4>Your Twitter Username</h4>
        <span class="pl-twitter">@ </span><?php echo form_input( 'twitter', "example" ); ?>
    </article>

    <br class="clear">

    <aside class="pl-generic-sidebar">
        <p></p>
    </aside>
    <article class="pl-main">
        <?php echo form_submit( 'submit', 'Setup' ); ?>
    </article>

    <?php echo form_close(); ?>

</section>
