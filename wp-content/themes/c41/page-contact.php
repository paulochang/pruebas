<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<h1 id="contact-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'Contact', 'c41' ); ?>&#47;</h1>

<div id="contact-info" class="margin-center">
  <p class="border-bottom">
    4a Calle Oriente no. 41<br/>
    La Antigua, Guatemala.<br/>
    <a class="line-through block" href="mailto:info@c-41.org">info@c-41.org</a><br/>
    (502)&nbsp;4157&nbsp;9535
  </p>
  
  <form id="contact-form" class="float-left" method="post" action="" data-action="c41_contact_submit">
    <label class="block uppercase" for="contact-name">&#47;<?php _e( 'Name', 'c41'); ?>&#47;</label>
    <input class="block border-all" id="contact-name" type="text" name="name"/>
    <label class="block uppercase" for="contact-mail">&#47;<?php _e( 'Email', 'c41'); ?>&#47;</label>
    <input class="block border-all" id="contact-mail" type="text" name="mail"/>
    <label class="block uppercase" for="contact-message">&#47;<?php _e( 'Message', 'c41'); ?>&#47;</label>
    <textarea class="block border-all" id="contact-message" name="message"></textarea>
    <input class="block border-all txt-center background-white uppercase pointer" id="contact-submit" type="submit" value="&#47;<?php _e( 'Submit', 'c41' ); ?>&#47;"/>
  </form>
  <iframe class="float-right" width="304" height="316" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?msa=0&amp;msid=200996837978672345901.0004d1d2e7ad1d54d73c2&amp;ie=UTF8&amp;t=m&amp;ll=14.557421,-90.727689&amp;spn=0,0&amp;output=embed"></iframe>
  <div class="form-update clear"></div>
</div>

<?php
if ( ! ajax () )
  get_footer (); ?>