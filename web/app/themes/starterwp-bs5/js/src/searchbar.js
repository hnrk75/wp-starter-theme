jQuery(document).ready(function($) {

    // Accordion effect on searchbar
    $( '.search-toggle' ).addClass( 'closing' );

    $( '.search-toggle .search-icon' ).on( 'click', function(e) {
        if ($( '.search-toggle' ).hasClass( 'closing' )) {
            $( '.search-toggle' ).removeClass( 'closing' ).addClass( 'opening' );
            $( '.search-toggle, .search-container' ).addClass( 'opening' );
            $( '#search-terms' ).focus();
        } else {
            $( '.search-toggle' ).removeClass( 'opening' ).addClass( 'closing' );
            $( '.search-toggle, .search-container' ).removeClass( 'opening' );
        }
    });

});
