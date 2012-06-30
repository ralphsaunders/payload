<?php

if( !isset( $posts ) || empty( $posts ) )
{
    $this->load->view( 'setup/explain' );
}
else
{
?>
<section class="pl-wrap">
    <section class="pl-sidebar">
        <p>I Design & Develop Things, Sometimes I Write About It Here</p>
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
<?php } ?>
