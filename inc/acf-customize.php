<?php
/**
 * Add height field to ACF WYSIWYG.
 */
function acf_render_field_settings_wysiwyg_height( $field ) {
	acf_render_field_setting( $field, array(
		'label'        => __( 'Height of Editor' ),
		'instructions' => __( 'Height of Editor after Init' ),
		'name'         => 'wysiwyg_height',
		'type'         => 'text'
	) );
}

add_action( 'acf/render_field_settings/type=wysiwyg', 'acf_render_field_settings_wysiwyg_height', 10, 1 );

/**
 * ACF WYSIWYG Height.
 */
function acf_render_field_wysiwyg_height( $field ) {
	$field_class = '.acf-' . str_replace( '_', '-', $field['key'] );

	?>

	<style>
		<?php echo $field_class; ?> iframe {
			min-height: 0;
		}
	</style>

	<script>
		var set_wysw_height;

		jQuery( '.acf-table > tbody' ).sortable( {
			start: function( event, ui ) {
				// alert( 'hello' );

				jQuery( '<?php echo $field_class; ?>' ).find( '#' + jQuery( this ).find( 'iframe' ).attr( 'id' ) ).css( 'height', '<?php echo $field['wysiwyg_height']; ?>' );
			}
		} );

		( function() {
			acf.add_action( 'wysiwyg_tinymce_init', function() {
				jQuery( '<?php echo $field_class; ?>' ).each( function() {
					jQuery( '#' + jQuery( this ).find( 'iframe' ).attr( 'id' ) ).css( 'height', '<?php echo $field['wysiwyg_height']; ?>' );
				} );
			} );
		} )( jQuery );
	</script>

	<?php
}

add_action( 'acf/render_field/type=wysiwyg', 'acf_render_field_wysiwyg_height', 10, 1 );