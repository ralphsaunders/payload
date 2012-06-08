Homepage

<?php $this->load->helper( 'url' ); ?>

<ul>
<?php if( isset( $posts ) ) : foreach( $posts as $post ): ?>
<li>
    <h3>
        <a href="./posted/<?php echo $post->{'url'}; ?>" title="Entry">
            <?php echo $post->{'title'} ?>
        </a>
    </h3>
</li>
<?php endforeach; endif; ?>
</ul>

<?php if( ! isset( $posts ) ) : ?>
You have no posts!
<?php endif; ?>
