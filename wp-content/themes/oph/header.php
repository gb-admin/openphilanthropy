<!doctype html>
<html lang="en-us">
	<head>

		<?php
			/**
			 * Google Tag Manager
			 */
			if ( class_exists( 'acf' ) && $google_tag_manager_id = get_field( 'google_tag_manager_id', 'options' ) ) {
				echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . $google_tag_manager_id . "');</script>";
			}
		?>

		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<style id="fix-dark-mode-flash">
			* { transition: none !important; }
		</style>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
			/**
			 * Google Tag Manager (noscript)
			 */
			if ( class_exists( 'acf' ) && $google_tag_manager_id__noscript = get_field( 'google_tag_manager_id', 'options' ) ) {
				echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . $google_tag_manager_id__noscript . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
			}
		?>

		<nav aria-label="Mobile Navigation" id="accessory">

			<?php
				wp_nav_menu( array(
					'container' => 'ul',
					'menu_class' => 'menu',
					'menu_id' => 'accessory-menu',
					'link_before' => '<span>',
					'link_after' => '</span><span class="menu-icon"></span>',
					'theme_location' => 'accessory'
				) );
			?>

			<div class="accessory-header">
				<div class="accessory-header__content">
					<button class="close" aria-label="Go back to page" title="Close">
						<span class="screen-reader-text">Close menu</span>

						<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47.971 47.971">
							<path d="M28.228,23.986L47.092,5.122c1.172-1.171,1.172-3.071,0-4.242c-1.172-1.172-3.07-1.172-4.242,0L23.986,19.744L5.121,0.88c-1.172-1.172-3.07-1.172-4.242,0c-1.172,1.171-1.172,3.071,0,4.242l18.865,18.864L0.879,42.85c-1.172,1.171-1.172,3.071,0,4.242C1.465,47.677,2.233,47.97,3,47.97s1.535-0.293,2.121-0.879l18.865-18.864L42.85,47.091c0.586,0.586,1.354,0.879,2.121,0.879s1.535-0.293,2.121-0.879c1.172-1.171,1.172-3.071,0-4.242L28.228,23.986z"/>
						</svg>
					</button>

					<span aria-hidden="true" class="logo">
						<a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo( 'name' ); ?> logo">
							<svg viewBox="0 0 192 60" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M34.987 16.404L43.704.867l1.495.838L32.751 23.89l1.265-18.287 1.71.118-.739 10.683zM11.592 15.65l15.204 10.24L13.808 4.018l-1.473.875L21.43 20.21l-8.882-5.981-.957 1.42zM35.693 35.452L48.68 57.324l1.474-.874-9.098-15.319 8.883 5.981.956-1.422-15.203-10.238zM.006 32.593l17.815-.064-9.66 4.618.739 1.546L25.199 30.9 0 30.88l.006 1.713zM60.535 28.976h-24.45l15.704-7.99.848 1.734-9.247 4.52 17.125.057.02 1.679zM16.282 58.294l1.495.838 8.717-15.537-.738 10.682 1.709.12 1.265-18.289-12.448 22.186zM30.304 27.672l-7.798-16.468 1.539-.752 4.7 9.62-.164-17.837h1.723v25.437zM31.482 57.765h1.713v-17.85l4.851 9.63 1.54-.752-8.104-16.267v25.239zM28.134 28.63H10.342l.013-1.518 10.986.002-15.615-8.997.817-1.455L28.134 28.63zM33.446 31.433L55.63 43.632l.837-1.494-16.621-9.327h11.793l-.014-1.378h-18.18zM19.097 46.389l-1.42-.957 5.98-8.882-15.319 9.097-.875-1.474 21.872-12.988-10.238 15.204zM42.99 12.972L32.752 28.176l21.872-12.987-.875-1.474-15.32 9.097 5.983-8.882-1.422-.958z" fill="#6E7CA0"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M74.226 22.792c-1.269 0-2.432-.219-3.488-.657-1.056-.439-1.972-1.045-2.748-1.82-.775-.775-1.378-1.7-1.809-2.772-.43-1.072-.646-2.234-.646-3.488 0-1.252.215-2.414.646-3.488.431-1.072 1.034-1.996 1.81-2.77.775-.776 1.691-1.383 2.747-1.82 1.056-.439 2.22-.659 3.488-.659 1.27 0 2.43.22 3.487.658 1.058.438 1.974 1.045 2.75 1.82.774.775 1.376 1.7 1.807 2.771.431 1.074.646 2.236.646 3.488 0 1.254-.215 2.416-.646 3.488-.43 1.072-1.033 1.997-1.808 2.772-.775.775-1.69 1.381-2.749 1.82-1.057.438-2.218.657-3.487.657zm0-1.83c.971 0 1.86-.182 2.666-.54.806-.36 1.5-.855 2.078-1.482.58-.626 1.03-1.357 1.351-2.195.321-.838.482-1.734.482-2.69 0-.954-.16-1.85-.482-2.689-.32-.838-.77-1.57-1.35-2.196-.58-.626-1.273-1.119-2.079-1.48-.807-.36-1.695-.54-2.666-.54-.972 0-1.859.18-2.666.54-.807.361-1.5.854-2.079 1.48-.579.626-1.029 1.358-1.35 2.196-.32.838-.482 1.735-.482 2.69 0 .955.161 1.851.482 2.69.321.837.771 1.568 1.35 2.194.58.627 1.272 1.121 2.08 1.481.806.36 1.693.54 2.665.54zM85.118 11.378h1.832v1.598h.046c.5-.596 1.085-1.058 1.75-1.387.666-.328 1.398-.492 2.196-.492.863 0 1.649.144 2.36.433.713.29 1.32.694 1.82 1.21.502.517.894 1.127 1.176 1.832.282.704.422 1.472.422 2.302 0 .83-.14 1.597-.422 2.302-.282.704-.67 1.315-1.163 1.832-.493.516-1.077.92-1.75 1.21-.673.29-1.393.434-2.161.434-.985 0-1.852-.215-2.595-.646-.743-.43-1.288-.959-1.633-1.586h-.046v7.306h-1.832V11.378zm1.832 5.496c0 .58.09 1.115.27 1.608.18.494.442.924.787 1.292.344.37.755.658 1.233.87.478.211 1.014.316 1.609.316s1.13-.105 1.608-.316c.478-.212.89-.5 1.234-.87.344-.368.607-.798.786-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.18-.492-.442-.924-.786-1.292-.344-.367-.756-.658-1.234-.869-.477-.21-1.013-.318-1.608-.318-.595 0-1.131.107-1.61.318-.477.211-.888.502-1.232.87-.345.367-.607.8-.787 1.291-.18.493-.27 1.03-.27 1.61zM108.833 20.373c-.657.846-1.378 1.437-2.16 1.773-.784.337-1.692.506-2.725.506-.862 0-1.636-.153-2.325-.459-.69-.305-1.272-.716-1.75-1.232-.478-.518-.845-1.127-1.103-1.833-.26-.704-.39-1.455-.39-2.254 0-.846.142-1.625.424-2.337.282-.712.673-1.323 1.175-1.832.501-.509 1.096-.904 1.785-1.186.688-.283 1.44-.423 2.255-.423.767 0 1.472.13 2.113.388.642.258 1.194.634 1.656 1.127.461.492.818 1.096 1.068 1.81.251.712.377 1.521.377 2.43v.586h-8.879c.032.47.145.92.341 1.351.195.431.45.807.763 1.127.313.321.682.575 1.104.764.423.187.885.282 1.386.282.799 0 1.471-.142 2.02-.423.547-.282 1.041-.696 1.48-1.245l1.385 1.08zm-1.573-4.485c-.032-.94-.337-1.693-.917-2.255-.579-.565-1.378-.846-2.395-.846-1.018 0-1.841.281-2.467.846-.626.562-1.001 1.315-1.127 2.255h6.906zM111.254 13.986c0-.502-.016-.972-.047-1.41-.031-.44-.047-.837-.047-1.197h1.739c0 .296.007.594.023.892.016.298.023.604.023.915h.046c.127-.265.303-.523.53-.775.227-.25.497-.473.81-.668.313-.195.665-.354 1.056-.47.392-.118.815-.177 1.269-.177.72 0 1.343.11 1.868.329.524.22.959.526 1.303.916.344.392.599.866.763 1.42.165.558.247 1.164.247 1.822v6.788h-1.832V15.77c0-.924-.204-1.651-.61-2.184-.409-.532-1.042-.798-1.903-.798-.595 0-1.108.1-1.539.304-.43.205-.782.494-1.057.87-.274.376-.477.822-.61 1.338-.134.517-.2 1.089-.2 1.715v5.356h-1.832v-8.385zM65.536 32.664h4.933c.766 0 1.498.075 2.195.224.697.148 1.315.399 1.856.75.54.353.97.823 1.29 1.41.323.588.483 1.312.483 2.173 0 .908-.172 1.66-.516 2.255-.345.594-.787 1.064-1.328 1.409-.54.344-1.131.588-1.772.728-.642.14-1.253.21-1.833.21h-3.335v7.47h-1.973v-16.63zm1.973 7.328h3.335c.987 0 1.789-.223 2.408-.67.618-.445.928-1.138.928-2.077 0-.94-.31-1.633-.928-2.08-.62-.446-1.421-.67-2.408-.67h-3.335v5.497zM78.315 31.537h1.832v8.29h.046c.126-.22.298-.434.518-.645.219-.211.48-.403.787-.576.305-.172.646-.313 1.02-.423.377-.11.776-.164 1.199-.164.72 0 1.343.11 1.868.329.524.219.959.525 1.303.917.344.39.599.864.763 1.42.165.556.247 1.163.247 1.82v6.788h-1.832v-6.6c0-.924-.204-1.652-.61-2.184-.41-.532-1.043-.8-1.903-.8-.595 0-1.108.103-1.54.307-.43.204-.781.493-1.056.869-.274.376-.477.822-.611 1.339-.133.516-.2 1.088-.2 1.713v5.356h-1.831V31.537zM90.568 34.002c0-.358.129-.672.388-.939.258-.266.575-.4.95-.4.377 0 .694.135.953.4.257.267.386.58.386.94 0 .392-.125.712-.375.962-.251.252-.572.377-.963.377-.392 0-.713-.125-.963-.377-.251-.25-.376-.57-.376-.963zm.423 15.29h1.832V38.3H90.99v10.992zM96.628 49.293h1.832V31.537h-1.832v17.756zM101.686 39.71c.562-.58 1.233-1.005 2.007-1.28.776-.273 1.563-.41 2.362-.41 1.628 0 2.802.383 3.522 1.15.72.767 1.081 1.934 1.081 3.5v4.721c0 .313.015.638.047.974.031.337.07.645.117.927h-1.761c-.063-.25-.099-.528-.106-.834-.008-.304-.012-.575-.012-.81h-.047c-.36.564-.842 1.026-1.444 1.386-.603.36-1.328.54-2.173.54-.563 0-1.092-.07-1.586-.21-.492-.142-.923-.348-1.292-.623-.367-.273-.66-.614-.879-1.022-.22-.407-.33-.877-.33-1.409 0-.909.235-1.622.705-2.138.47-.516 1.053-.9 1.75-1.15.696-.25 1.448-.407 2.255-.47.806-.063 1.545-.094 2.219-.094h.705v-.33c0-.797-.239-1.4-.717-1.807-.477-.407-1.147-.611-2.007-.611-.596 0-1.18.099-1.75.294-.573.196-1.077.498-1.516.904l-1.15-1.199zm5.308 4.297c-1.175 0-2.106.166-2.795.495-.69.328-1.034.868-1.034 1.62 0 .69.231 1.178.694 1.468.461.29 1.036.434 1.726.434.532 0 .998-.09 1.397-.27.399-.18.732-.418.998-.716.267-.297.47-.645.611-1.044.141-.4.219-.827.235-1.282v-.705h-1.832zM113.744 40.908c0-.501-.017-.971-.048-1.408-.031-.44-.047-.838-.047-1.2h1.739c0 .298.007.596.023.894.015.298.024.603.024.915h.047c.124-.265.301-.523.528-.775.227-.25.497-.473.81-.67.313-.194.666-.352 1.057-.47.391-.116.814-.175 1.268-.175.721 0 1.344.11 1.868.329.524.219.959.525 1.303.916.345.392.599.866.764 1.42.164.557.246 1.164.246 1.822v6.787h-1.832v-6.601c0-.923-.203-1.651-.611-2.183-.407-.533-1.041-.8-1.902-.8-.595 0-1.108.103-1.539.306-.43.205-.782.494-1.056.87s-.478.822-.61 1.338c-.134.517-.201 1.089-.201 1.715v5.355h-1.831v-8.385zM132.268 39.851h-3.242v5.496c0 .359.008.692.024.998.015.305.079.571.188.798.11.228.274.408.494.541.219.133.532.199.939.199.266 0 .54-.031.822-.094.282-.062.547-.156.798-.282l.071 1.667c-.314.142-.662.243-1.045.306-.384.063-.748.095-1.092.095-.658 0-1.183-.087-1.574-.259-.391-.172-.697-.415-.916-.729-.22-.312-.364-.7-.435-1.162-.07-.461-.105-.973-.105-1.538v-6.036h-2.396V38.3h2.396v-3.124h1.831V38.3h3.242v1.551zM134.523 31.537h1.832v8.29h.047c.125-.22.297-.434.517-.645.219-.211.481-.403.787-.576.305-.172.646-.313 1.022-.423.376-.11.774-.164 1.197-.164.72 0 1.343.11 1.868.329.524.219.959.525 1.303.917.344.39.599.864.763 1.42.165.556.247 1.163.247 1.82v6.788h-1.832v-6.6c0-.924-.204-1.652-.61-2.184-.409-.532-1.042-.8-1.903-.8-.595 0-1.108.103-1.539.307-.43.204-.782.493-1.057.869-.274.376-.477.822-.61 1.339-.134.516-.2 1.088-.2 1.713v5.356h-1.832V31.537zM147.112 40.908c0-.501-.017-.971-.048-1.408-.031-.44-.047-.838-.047-1.2h1.739c0 .298.007.596.023.894.015.298.024.603.024.915h.047c.124-.265.301-.523.528-.775.227-.25.497-.473.809-.67.314-.194.667-.352 1.058-.47.391-.116.814-.175 1.268-.175.125 0 .251.008.377.024.124.015.249.047.375.094l-.118 1.855c-.313-.094-.642-.141-.986-.141-1.127 0-1.946.365-2.454 1.092-.509.728-.764 1.727-.764 2.995v5.355h-1.831v-8.385zM154.149 43.797c0-.86.148-1.645.446-2.35.298-.704.704-1.31 1.221-1.82.518-.509 1.136-.903 1.856-1.185.721-.283 1.503-.423 2.349-.423.846 0 1.628.14 2.349.423.72.282 1.338.676 1.854 1.185.518.51.924 1.116 1.222 1.82.298.705.447 1.49.447 2.35 0 .86-.149 1.644-.447 2.35-.298.703-.704 1.31-1.222 1.818-.516.51-1.134.905-1.854 1.186-.721.282-1.503.423-2.349.423-.846 0-1.628-.14-2.349-.423-.72-.28-1.338-.676-1.856-1.186-.517-.508-.923-1.115-1.221-1.819-.298-.705-.446-1.489-.446-2.349zm1.973 0c0 .58.09 1.115.27 1.608.18.494.443.924.787 1.292.344.37.755.658 1.233.87.477.21 1.013.316 1.609.316.595 0 1.13-.106 1.609-.316.477-.212.888-.5 1.233-.87.345-.368.606-.798.787-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.181-.494-.442-.924-.787-1.292-.345-.369-.756-.659-1.233-.87-.479-.21-1.014-.317-1.609-.317-.596 0-1.132.107-1.609.317-.478.211-.889.501-1.233.87-.344.368-.607.798-.787 1.292-.18.493-.27 1.03-.27 1.61zM167.882 38.3h1.832v1.598h.047c.501-.595 1.084-1.058 1.751-1.386.665-.329 1.396-.493 2.196-.493.861 0 1.647.145 2.36.434.712.29 1.318.693 1.819 1.21.501.516.893 1.127 1.175 1.831.283.705.424 1.473.424 2.303 0 .83-.141 1.597-.424 2.301-.282.705-.668 1.316-1.163 1.832-.493.516-1.076.921-1.749 1.21-.673.29-1.394.434-2.162.434-.985 0-1.851-.214-2.594-.646-.744-.43-1.289-.959-1.633-1.585h-.047v7.305h-1.832V38.3zm1.832 5.497c0 .58.09 1.115.271 1.608.18.494.441.924.787 1.292.344.37.754.658 1.233.87.478.211 1.013.316 1.608.316.596 0 1.131-.105 1.608-.317.478-.21.89-.5 1.234-.869.344-.368.607-.798.787-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.18-.493-.443-.924-.787-1.292-.344-.368-.756-.659-1.234-.869-.477-.21-1.012-.318-1.608-.318-.595 0-1.13.107-1.608.318-.479.21-.889.501-1.233.87-.346.367-.607.798-.787 1.291-.181.493-.271 1.03-.271 1.61zM186.882 49.546c-.187.47 0 0-1.915 5.133h-1.873l1.778-5.317-4.557-11.062h2.137l3.407 8.621h.046l3.265-8.62h1.996l-4.284 11.245z" fill="#241F21"/>
							</svg>
						</a>
					</span>
				</div>
			</div>

			<?php
				$url_facebook = get_field( 'url_facebook', 'options' );
				$url_twitter = get_field( 'url_twitter', 'options' );
			?>

			<?php if ( $url_facebook || $url_twitter ) : ?>
				<div class="social-media">
					<?php if ( $url_facebook ) : ?>
						<a class="social-media__twitter" href="<?php echo $url_facebook; ?>">
							<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
						</a>
					<?php endif; ?>

					<?php if ( $url_twitter ) : ?>
						<a class="social-media__facebook" href="<?php echo $url_twitter; ?>">
							<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</nav>

		<header class="<?php if ( is_front_page() ) { echo 'is-front-page'; } ?>" id="header">
			<span class="wrap">
				<span class="header-content">
					<nav id="primary">

						<?php
							wp_nav_menu( array(
								'container' => 'ul',
								'menu_class' => 'menu',
								'menu_id' => 'primary-menu',
								'theme_location' => 'primary'
							) );
						?>
					</nav>

					<span aria-hidden="true" class="logo">
						<a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo( 'name' ); ?> logo">
							<svg viewBox="0 0 192 60" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M34.987 16.404L43.704.867l1.495.838L32.751 23.89l1.265-18.287 1.71.118-.739 10.683zM11.592 15.65l15.204 10.24L13.808 4.018l-1.473.875L21.43 20.21l-8.882-5.981-.957 1.42zM35.693 35.452L48.68 57.324l1.474-.874-9.098-15.319 8.883 5.981.956-1.422-15.203-10.238zM.006 32.593l17.815-.064-9.66 4.618.739 1.546L25.199 30.9 0 30.88l.006 1.713zM60.535 28.976h-24.45l15.704-7.99.848 1.734-9.247 4.52 17.125.057.02 1.679zM16.282 58.294l1.495.838 8.717-15.537-.738 10.682 1.709.12 1.265-18.289-12.448 22.186zM30.304 27.672l-7.798-16.468 1.539-.752 4.7 9.62-.164-17.837h1.723v25.437zM31.482 57.765h1.713v-17.85l4.851 9.63 1.54-.752-8.104-16.267v25.239zM28.134 28.63H10.342l.013-1.518 10.986.002-15.615-8.997.817-1.455L28.134 28.63zM33.446 31.433L55.63 43.632l.837-1.494-16.621-9.327h11.793l-.014-1.378h-18.18zM19.097 46.389l-1.42-.957 5.98-8.882-15.319 9.097-.875-1.474 21.872-12.988-10.238 15.204zM42.99 12.972L32.752 28.176l21.872-12.987-.875-1.474-15.32 9.097 5.983-8.882-1.422-.958z" fill="#6E7CA0"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M74.226 22.792c-1.269 0-2.432-.219-3.488-.657-1.056-.439-1.972-1.045-2.748-1.82-.775-.775-1.378-1.7-1.809-2.772-.43-1.072-.646-2.234-.646-3.488 0-1.252.215-2.414.646-3.488.431-1.072 1.034-1.996 1.81-2.77.775-.776 1.691-1.383 2.747-1.82 1.056-.439 2.22-.659 3.488-.659 1.27 0 2.43.22 3.487.658 1.058.438 1.974 1.045 2.75 1.82.774.775 1.376 1.7 1.807 2.771.431 1.074.646 2.236.646 3.488 0 1.254-.215 2.416-.646 3.488-.43 1.072-1.033 1.997-1.808 2.772-.775.775-1.69 1.381-2.749 1.82-1.057.438-2.218.657-3.487.657zm0-1.83c.971 0 1.86-.182 2.666-.54.806-.36 1.5-.855 2.078-1.482.58-.626 1.03-1.357 1.351-2.195.321-.838.482-1.734.482-2.69 0-.954-.16-1.85-.482-2.689-.32-.838-.77-1.57-1.35-2.196-.58-.626-1.273-1.119-2.079-1.48-.807-.36-1.695-.54-2.666-.54-.972 0-1.859.18-2.666.54-.807.361-1.5.854-2.079 1.48-.579.626-1.029 1.358-1.35 2.196-.32.838-.482 1.735-.482 2.69 0 .955.161 1.851.482 2.69.321.837.771 1.568 1.35 2.194.58.627 1.272 1.121 2.08 1.481.806.36 1.693.54 2.665.54zM85.118 11.378h1.832v1.598h.046c.5-.596 1.085-1.058 1.75-1.387.666-.328 1.398-.492 2.196-.492.863 0 1.649.144 2.36.433.713.29 1.32.694 1.82 1.21.502.517.894 1.127 1.176 1.832.282.704.422 1.472.422 2.302 0 .83-.14 1.597-.422 2.302-.282.704-.67 1.315-1.163 1.832-.493.516-1.077.92-1.75 1.21-.673.29-1.393.434-2.161.434-.985 0-1.852-.215-2.595-.646-.743-.43-1.288-.959-1.633-1.586h-.046v7.306h-1.832V11.378zm1.832 5.496c0 .58.09 1.115.27 1.608.18.494.442.924.787 1.292.344.37.755.658 1.233.87.478.211 1.014.316 1.609.316s1.13-.105 1.608-.316c.478-.212.89-.5 1.234-.87.344-.368.607-.798.786-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.18-.492-.442-.924-.786-1.292-.344-.367-.756-.658-1.234-.869-.477-.21-1.013-.318-1.608-.318-.595 0-1.131.107-1.61.318-.477.211-.888.502-1.232.87-.345.367-.607.8-.787 1.291-.18.493-.27 1.03-.27 1.61zM108.833 20.373c-.657.846-1.378 1.437-2.16 1.773-.784.337-1.692.506-2.725.506-.862 0-1.636-.153-2.325-.459-.69-.305-1.272-.716-1.75-1.232-.478-.518-.845-1.127-1.103-1.833-.26-.704-.39-1.455-.39-2.254 0-.846.142-1.625.424-2.337.282-.712.673-1.323 1.175-1.832.501-.509 1.096-.904 1.785-1.186.688-.283 1.44-.423 2.255-.423.767 0 1.472.13 2.113.388.642.258 1.194.634 1.656 1.127.461.492.818 1.096 1.068 1.81.251.712.377 1.521.377 2.43v.586h-8.879c.032.47.145.92.341 1.351.195.431.45.807.763 1.127.313.321.682.575 1.104.764.423.187.885.282 1.386.282.799 0 1.471-.142 2.02-.423.547-.282 1.041-.696 1.48-1.245l1.385 1.08zm-1.573-4.485c-.032-.94-.337-1.693-.917-2.255-.579-.565-1.378-.846-2.395-.846-1.018 0-1.841.281-2.467.846-.626.562-1.001 1.315-1.127 2.255h6.906zM111.254 13.986c0-.502-.016-.972-.047-1.41-.031-.44-.047-.837-.047-1.197h1.739c0 .296.007.594.023.892.016.298.023.604.023.915h.046c.127-.265.303-.523.53-.775.227-.25.497-.473.81-.668.313-.195.665-.354 1.056-.47.392-.118.815-.177 1.269-.177.72 0 1.343.11 1.868.329.524.22.959.526 1.303.916.344.392.599.866.763 1.42.165.558.247 1.164.247 1.822v6.788h-1.832V15.77c0-.924-.204-1.651-.61-2.184-.409-.532-1.042-.798-1.903-.798-.595 0-1.108.1-1.539.304-.43.205-.782.494-1.057.87-.274.376-.477.822-.61 1.338-.134.517-.2 1.089-.2 1.715v5.356h-1.832v-8.385zM65.536 32.664h4.933c.766 0 1.498.075 2.195.224.697.148 1.315.399 1.856.75.54.353.97.823 1.29 1.41.323.588.483 1.312.483 2.173 0 .908-.172 1.66-.516 2.255-.345.594-.787 1.064-1.328 1.409-.54.344-1.131.588-1.772.728-.642.14-1.253.21-1.833.21h-3.335v7.47h-1.973v-16.63zm1.973 7.328h3.335c.987 0 1.789-.223 2.408-.67.618-.445.928-1.138.928-2.077 0-.94-.31-1.633-.928-2.08-.62-.446-1.421-.67-2.408-.67h-3.335v5.497zM78.315 31.537h1.832v8.29h.046c.126-.22.298-.434.518-.645.219-.211.48-.403.787-.576.305-.172.646-.313 1.02-.423.377-.11.776-.164 1.199-.164.72 0 1.343.11 1.868.329.524.219.959.525 1.303.917.344.39.599.864.763 1.42.165.556.247 1.163.247 1.82v6.788h-1.832v-6.6c0-.924-.204-1.652-.61-2.184-.41-.532-1.043-.8-1.903-.8-.595 0-1.108.103-1.54.307-.43.204-.781.493-1.056.869-.274.376-.477.822-.611 1.339-.133.516-.2 1.088-.2 1.713v5.356h-1.831V31.537zM90.568 34.002c0-.358.129-.672.388-.939.258-.266.575-.4.95-.4.377 0 .694.135.953.4.257.267.386.58.386.94 0 .392-.125.712-.375.962-.251.252-.572.377-.963.377-.392 0-.713-.125-.963-.377-.251-.25-.376-.57-.376-.963zm.423 15.29h1.832V38.3H90.99v10.992zM96.628 49.293h1.832V31.537h-1.832v17.756zM101.686 39.71c.562-.58 1.233-1.005 2.007-1.28.776-.273 1.563-.41 2.362-.41 1.628 0 2.802.383 3.522 1.15.72.767 1.081 1.934 1.081 3.5v4.721c0 .313.015.638.047.974.031.337.07.645.117.927h-1.761c-.063-.25-.099-.528-.106-.834-.008-.304-.012-.575-.012-.81h-.047c-.36.564-.842 1.026-1.444 1.386-.603.36-1.328.54-2.173.54-.563 0-1.092-.07-1.586-.21-.492-.142-.923-.348-1.292-.623-.367-.273-.66-.614-.879-1.022-.22-.407-.33-.877-.33-1.409 0-.909.235-1.622.705-2.138.47-.516 1.053-.9 1.75-1.15.696-.25 1.448-.407 2.255-.47.806-.063 1.545-.094 2.219-.094h.705v-.33c0-.797-.239-1.4-.717-1.807-.477-.407-1.147-.611-2.007-.611-.596 0-1.18.099-1.75.294-.573.196-1.077.498-1.516.904l-1.15-1.199zm5.308 4.297c-1.175 0-2.106.166-2.795.495-.69.328-1.034.868-1.034 1.62 0 .69.231 1.178.694 1.468.461.29 1.036.434 1.726.434.532 0 .998-.09 1.397-.27.399-.18.732-.418.998-.716.267-.297.47-.645.611-1.044.141-.4.219-.827.235-1.282v-.705h-1.832zM113.744 40.908c0-.501-.017-.971-.048-1.408-.031-.44-.047-.838-.047-1.2h1.739c0 .298.007.596.023.894.015.298.024.603.024.915h.047c.124-.265.301-.523.528-.775.227-.25.497-.473.81-.67.313-.194.666-.352 1.057-.47.391-.116.814-.175 1.268-.175.721 0 1.344.11 1.868.329.524.219.959.525 1.303.916.345.392.599.866.764 1.42.164.557.246 1.164.246 1.822v6.787h-1.832v-6.601c0-.923-.203-1.651-.611-2.183-.407-.533-1.041-.8-1.902-.8-.595 0-1.108.103-1.539.306-.43.205-.782.494-1.056.87s-.478.822-.61 1.338c-.134.517-.201 1.089-.201 1.715v5.355h-1.831v-8.385zM132.268 39.851h-3.242v5.496c0 .359.008.692.024.998.015.305.079.571.188.798.11.228.274.408.494.541.219.133.532.199.939.199.266 0 .54-.031.822-.094.282-.062.547-.156.798-.282l.071 1.667c-.314.142-.662.243-1.045.306-.384.063-.748.095-1.092.095-.658 0-1.183-.087-1.574-.259-.391-.172-.697-.415-.916-.729-.22-.312-.364-.7-.435-1.162-.07-.461-.105-.973-.105-1.538v-6.036h-2.396V38.3h2.396v-3.124h1.831V38.3h3.242v1.551zM134.523 31.537h1.832v8.29h.047c.125-.22.297-.434.517-.645.219-.211.481-.403.787-.576.305-.172.646-.313 1.022-.423.376-.11.774-.164 1.197-.164.72 0 1.343.11 1.868.329.524.219.959.525 1.303.917.344.39.599.864.763 1.42.165.556.247 1.163.247 1.82v6.788h-1.832v-6.6c0-.924-.204-1.652-.61-2.184-.409-.532-1.042-.8-1.903-.8-.595 0-1.108.103-1.539.307-.43.204-.782.493-1.057.869-.274.376-.477.822-.61 1.339-.134.516-.2 1.088-.2 1.713v5.356h-1.832V31.537zM147.112 40.908c0-.501-.017-.971-.048-1.408-.031-.44-.047-.838-.047-1.2h1.739c0 .298.007.596.023.894.015.298.024.603.024.915h.047c.124-.265.301-.523.528-.775.227-.25.497-.473.809-.67.314-.194.667-.352 1.058-.47.391-.116.814-.175 1.268-.175.125 0 .251.008.377.024.124.015.249.047.375.094l-.118 1.855c-.313-.094-.642-.141-.986-.141-1.127 0-1.946.365-2.454 1.092-.509.728-.764 1.727-.764 2.995v5.355h-1.831v-8.385zM154.149 43.797c0-.86.148-1.645.446-2.35.298-.704.704-1.31 1.221-1.82.518-.509 1.136-.903 1.856-1.185.721-.283 1.503-.423 2.349-.423.846 0 1.628.14 2.349.423.72.282 1.338.676 1.854 1.185.518.51.924 1.116 1.222 1.82.298.705.447 1.49.447 2.35 0 .86-.149 1.644-.447 2.35-.298.703-.704 1.31-1.222 1.818-.516.51-1.134.905-1.854 1.186-.721.282-1.503.423-2.349.423-.846 0-1.628-.14-2.349-.423-.72-.28-1.338-.676-1.856-1.186-.517-.508-.923-1.115-1.221-1.819-.298-.705-.446-1.489-.446-2.349zm1.973 0c0 .58.09 1.115.27 1.608.18.494.443.924.787 1.292.344.37.755.658 1.233.87.477.21 1.013.316 1.609.316.595 0 1.13-.106 1.609-.316.477-.212.888-.5 1.233-.87.345-.368.606-.798.787-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.181-.494-.442-.924-.787-1.292-.345-.369-.756-.659-1.233-.87-.479-.21-1.014-.317-1.609-.317-.596 0-1.132.107-1.609.317-.478.211-.889.501-1.233.87-.344.368-.607.798-.787 1.292-.18.493-.27 1.03-.27 1.61zM167.882 38.3h1.832v1.598h.047c.501-.595 1.084-1.058 1.751-1.386.665-.329 1.396-.493 2.196-.493.861 0 1.647.145 2.36.434.712.29 1.318.693 1.819 1.21.501.516.893 1.127 1.175 1.831.283.705.424 1.473.424 2.303 0 .83-.141 1.597-.424 2.301-.282.705-.668 1.316-1.163 1.832-.493.516-1.076.921-1.749 1.21-.673.29-1.394.434-2.162.434-.985 0-1.851-.214-2.594-.646-.744-.43-1.289-.959-1.633-1.585h-.047v7.305h-1.832V38.3zm1.832 5.497c0 .58.09 1.115.271 1.608.18.494.441.924.787 1.292.344.37.754.658 1.233.87.478.211 1.013.316 1.608.316.596 0 1.131-.105 1.608-.317.478-.21.89-.5 1.234-.869.344-.368.607-.798.787-1.292.18-.493.27-1.029.27-1.608 0-.579-.09-1.116-.27-1.609-.18-.493-.443-.924-.787-1.292-.344-.368-.756-.659-1.234-.869-.477-.21-1.012-.318-1.608-.318-.595 0-1.13.107-1.608.318-.479.21-.889.501-1.233.87-.346.367-.607.798-.787 1.291-.181.493-.271 1.03-.271 1.61zM186.882 49.546c-.187.47 0 0-1.915 5.133h-1.873l1.778-5.317-4.557-11.062h2.137l3.407 8.621h.046l3.265-8.62h1.996l-4.284 11.245z" fill="#241F21"/>
							</svg>
						</a>
					</span>
				</span>
			</span>

			<button aria-label="Mobile Navigation Toggle" id="accessory-toggle">
				<span class="screen-reader-text">Mobile Navigation Toggle</span>

				<svg viewBox="0 0 27 21" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h27v3H0zM0 9h27v3H0zM0 18h27v3H0z"/></svg>
			</button>
		</header>

		<div id="page">
			<main id="main">