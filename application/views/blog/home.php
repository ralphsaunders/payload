<?php
$this->load->helper( 'url' );
$this->load->helper( 'naming' );
?>

<section class="pl-posts">

    <h1>articles</h1>

    <ul class="pl-post-list">
    <?php if( isset( $posts ) ) : foreach( $posts as $post ): ?>
        <li>
            <h3>
                <a href="<?php echo $post['relative_path'] . $post['name']; ?>"
                   title="<?php echo title_case( $post['name'] ); ?>"
                ><?php echo title_case( $post['name'] ); ?></a>
            </h3>
        </li>
    <?php endforeach; endif; ?>
    </ul>

</section>

<?php if( ! isset( $posts ) || empty( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
