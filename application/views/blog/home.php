Homepage

<?php
$this->load->helper( 'url' );
$this->load->helper( 'naming' );
?>

<pre>
<?php var_dump( $posts ); ?>
</pre>

<ul>
<?php if( isset( $posts ) ) : foreach( $posts as $post ): ?>
    <li>
        <a href="<?php echo $post['relative_path'] . $post['name']; ?>"
           title="<?php echo title_case( $post['name'] ); ?>"
        ><?php echo title_case( $post['name'] ); ?></a>
    </li>
<?php endforeach; endif; ?>
</ul>

<?php if( ! isset( $posts ) || empty( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
