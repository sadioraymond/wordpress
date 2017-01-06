<?php if(have_comments()) : ?>
<h4 id= "comments"> <?php comments_number( 'Aucun Commentaire', 'Un commentaire', '% commentaire');?></h4>
<ul class="comment-list">
<?php wp_list_comments('callback=custom_comments'); ?>
</ul>
<?php endif ?>

<?php 
									$comments_args = array(
        // change the title of send button 
        'label_submit'=>'Valider',
        // change the title of the reply section
        'title_reply'=>'Commenter',
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
);
comment_form($comments_args); ?>