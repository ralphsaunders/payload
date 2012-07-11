<?php

if( !isset( $posts ) || empty( $posts ) )
{
    $this->load->view( 'setup/explain' );
}
else
{
?>
<section class="pl-wrap">
    <section class="pl-body">
        <ul class="pl-post-list">
            <li class="pl-posts">
                <?php echo $posts; ?>
            </li>
        </ul>
    </section>
</section>
<?php } ?>
