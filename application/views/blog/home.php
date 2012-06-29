<section class="pl-wrap">
    <section class="pl-sidebar">
        <h6>I Design & Develop Things, Sometimes I Write About It Here</h6>
    </section>
    <section class="pl-posts">

        <h1>Ralph Saunders &mdash; Blog</h1>

        <ul class="pl-post-list">
            <li class="pl-posts">
                <?php echo $posts; ?>
            </li>
        </ul>

    </section>
</section>

<?php if( ! isset( $posts ) || empty( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
