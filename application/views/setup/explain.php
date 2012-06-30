<div class="pl-wrap">

    <header>
        <aside class="notification pl-three-col">
            <p>You're seeing this because you haven't uploaded any posts yet. Read on to find out what you need to know.</p>
        </aside>

        <div class="pl-three-col last right info">
        <p>If you want to find this page again, you can at <?php echo anchor( 'payload', '/payload' ); ?>.</p>

            <p><a href="">pl@ralphsaunders.co.uk</a>.</p>
        </div>

        <img src="<?php echo base_url(); ?>assets/images/payload-banner.jpg" alt="Payload: An Experiment In Web Publishing Technology" />
    </header>

    <article>
        <section id="intro">
            <aside class="pl-sidebar">
                <h3>Contents</h3>
                <ol>
                    <li><a href="#payload-for">What's Payload For?</a></li>
                    <li><a href="#use-payload">Using Payload</a></li>
                    <li><a href="#modify-payload">Modifying Payload</a></li>
                </ol>
            </aside>

            <div class="pl-body" id="payload-for">
                <h1>What's Payload For?</h1>

                <p>Payload was created out of the frustration that working with more complex content management systems caused. Have you ever tried doing custom HTML &amp; CSS for one specific post on Wordpress? It's convoluted to say the least. So this is where Payload comes in. It just mirrors whatever you dump in the /posted/ fold<em>r. *That's</em> it*.</p>

                <p>Payload is for advanced webpage publishing. Got an interactive info graphic? A WebGL demo? A javascript powered game? Payload gives you a way to publish these experiences without getting in the way.</p>

            </div>
            <br class="clear">
        </section>
        <section id="use-payload">
            <h1 class="pl-body">Using Payload</h1>

            <br class="clear">

            <div class="pl-sidebar" id="using-pl-sub">
                <h3>Things You Should Know</h3>
            </div>
            <div class="pl-body">
                <img src="<?php echo base_url(); ?>assets/images/using-payload.jpg" alt="Payload is Pretty Simple Stuff" />
            </div>

            <br class="clear">

            <section id="you-should-know">

                <div class="pl-three-col">
                    <h4>Payload Mirrors</h4>
                    <p>Payload mirrors the /posted/ directory. Everything placed in there is public, so it's probably best if you don't go storing your passwords there.</p>
                </div>

                <div class="pl-three-col">
                    <h4>Payload is New</h4>
                    <p>Payload is very new and hasn't been tested a whole bunch. There will be bugs and some of them may be particularly nasty. I'm working to solve these, so if you come across one please contact <a href="">pl@ralphsaunders.co.uk</a> with the details.</p>
                </div>

                <div class="pl-three-col last">
                    <h4>Payload is Destructive</h4>
                    <p>Payload renames HTML files placed in the /posted/ directory to index.html. <em>All of them</em>.</p>
                </div>

                <br class="clear">

                <div class="pl-body">
                    <p>Please also note, that Payload has only been tested with small scale sites (less than 50 entries), and so it isn't clear how it performs at scale. If you're having issues, please submit them to the <a href="" title="">Github repository</a>.</p>
                </div>
            </section>

            <br class="clear">

            <section>
                <div class="pl-body">
                    <h2>How The /posted/ Directory Works</h2>

                    <p>Payload looks in /posted/ for your posts. It isn't limited to one post per subdirectory however; you can use subdirectories as categories, dividing up your posts manually. Here's an example:</p>
                </div>

                <br class="clear">

<pre><code>|~posted/</code>
<code>  |~articles/</code>
<code>    |~an-article/</code>
<code>      |-index.html</code>
<code>      |-image.png</code>
<code>      `-styles.css</code>
<code>    |~another-article/</code>
<code>      |-index.html</code>
<code>      `-styles.css</code>
<code>  |~portfolio/</code>
<code>    |~portfolio-piece/</code>
<code>      |-index.html</code>
<code>      |-image.png</code>
<code>      `-logo.png</code>
</pre>

<p class="pl-body">That's a possible directory structure that would work with payload. Here's that directory structure in markup:</p>

<pre>
<code>&lt;ul&gt;</code>
<code>	&lt;li&gt;&lt;h2&gt;Articles&lt;/h2&gt;&lt;/li&gt;</code>
<code>	&lt;li&gt;</code>
<code>		&lt;ul&gt;</code>
<code>			&lt;li&gt;</code>
<code>				&lt;h3&gt;&lt;a href=&quot;/posted/articles/an-article/&quot;&gt;An Article&lt;/a&gt;&lt;/h3&gt;</code>
<code>			&lt;/li&gt;</code>
<code>			&lt;li&gt;</code>
<code>				&lt;h3&gt;&lt;a href=&quot;/posted/articles/another-article/&quot;&gt;Another Article&lt;/a&gt;&lt;/h3&gt;</code>
<code>			&lt;/li&gt;</code>
<code>		&lt;/ul&gt;</code>
<code>	&lt;/li&gt;</code>
<code>&lt;/ul&gt;</code>
<code>&lt;ul&gt;</code>
<code>	&lt;li&gt;&lt;h2&gt;Portfolio&lt;/h2&gt;&lt;/li&gt;</code>
<code>	&lt;li&gt;</code>
<code>		&lt;ul&gt;</code>
<code>			&lt;li&gt;</code>
<code>				&lt;h3&gt;&lt;a href=&quot;/posted/portfolio/portfolio-piece/&quot;&gt;Portfolio Piece&lt;/a&gt;&lt;/h3&gt;</code>
<code>			&lt;/li&gt;</code>
<code>		&lt;/ul&gt;</code>
<code>	&lt;/li&gt;</code>
<code>&lt;/ul&gt;</code>
</pre>

                <p class="pl-body">You can see that the names of the categories are derived directly from their directory names, as are the post titles.</p>
            </section>
        </section><!-- Closes 'Using Payload' Section -->

        <section id="modify-payload">

            <div class="pl-body">
                <h2>Modifying Payload</h2>
            </div>

        </section>

    </article>
</div>
