Homepage

<ul>
<?php if( isset( $posts ) ) : foreach( $posts as $post ): ?>
<li>
    <h3>
        <?php echo anchor( $post['url'], $post['title'] ); ?>
    </h3>
</li>
<?php endforeach; endif; ?>
</ul>

<?php if( ! isset( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
