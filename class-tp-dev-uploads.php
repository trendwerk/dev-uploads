<?php
/**
 * Plugin Name: Development uploads
 * Description: Placeholder images for development and staging environments.
 */

class TP_Dev_Uploads {
	function __construct() {
		add_filter( 'mod_rewrite_rules', array( $this, 'placehold' ) );
	}

	/**
	 * Redirect images from uploads to placehold.it on develop and release environments if they don't exist
	 * 
	 * @param  string $rules WordPress' own rules
	 * @return string        New rules
	 */
	function placehold( $rules ) {
		if( 'develop' == TP_ENV || 'release' == TP_ENV ) {
			$tp_images_rules = array(
				'#BEGIN TrendPress placeholder images',
				'RewriteCond %{REQUEST_FILENAME} !-f',
				'RewriteRule ^wp-content/uploads/(.*)-([0-9]+)x([0-9]+).(gif|jpe?g|png|bmp)$ http://placehold.it/$2x$3 [NC,L]',
				'RewriteCond %{REQUEST_FILENAME} !-f',
				'RewriteRule ^wp-content/uploads/(.*)(gif|jpe?g|png|bmp)$ http://placehold.it/600x600 [NC,L]',
				'#END TrendPress placeholder images',
				'',
			);

			$rules = explode( "\n", $rules );
			$rules = wp_parse_args( $rules, $tp_images_rules );
			$rules = implode( "\n", $rules );
		}

		return $rules;
	}
} new TP_Dev_Uploads;
