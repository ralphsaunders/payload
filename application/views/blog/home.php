Homepage

<?php
$this->load->helper( 'url' );
$this->load->helper( 'naming' );
?>

<?php var_dump( $posts ); ?>

<ul>
<?php if( isset( $posts ) ) : foreach( $posts as $post ): ?>
    <li>
        <a href="<?php echo $post['relative_path'] . $post['name']; ?>"
           title="<?php echo title_case( $post['name'] ); ?>"
        ><?php echo title_case( $post['name'] ); ?></a>
    </li>
<?php endforeach; endif; ?>
</ul>

<?php if( ! isset( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
