
function Anass_url_spamcheck( $approved , $commentdata ) {
    return ( strlen( $commentdata['comment_author_url'] ) > 50 ) ? 'spam' : $approved;
}

add_filter( 'pre_comment_approved', Anass_url_spamcheck', 99, 2 );
 
