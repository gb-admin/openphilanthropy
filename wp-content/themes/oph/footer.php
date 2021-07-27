			</main>

			<?php
				$address_city = get_field( 'address_city', 'options' );
				$address_state = get_field( 'address_state', 'options' );
				$address_street = get_field( 'address_street', 'options' );
				$address_unit = get_field( 'address_unit', 'options' );
				$address_zipcode = get_field( 'address_zipcode', 'options' );
				$footer_email = get_field( 'footer_email', 'options' );
				$footer_newsletter_content = get_field( 'footer_newsletter_content', 'options' );
				$footer_newsletter_title = get_field( 'footer_newsletter_title', 'options' );
				$footer_phone = get_field( 'footer_phone', 'options' );
			?>

			<footer id="footer">
				<div class="wrap">
					<div class="footer__content">
						<div class="footer-grid">
							<div class="footer-grid__cell footer-cell-logo">
								<div class="logo">
									<a href="/">
										<img src="<?php echo get_template_directory_uri() . '/ui/img/open-philanthropy-footer-logo.png'; ?>" alt="Open Philanthropy">
									</a>
								</div>

								<div class="logo-mobile">
									<a href="/">
										<img src="<?php echo get_template_directory_uri() . '/ui/img/open-philanthropy-footer-mobile-logo.png'; ?>" alt="Open Philanthropy">
									</a>
								</div>
							</div>

							<div class="footer-grid__cell footer-cell-menu">
								<ul>
									<li>
										<a href="">Careers</a>
									</li>
									<li>
										<a href="">Press kit</a>
									</li>
									<li>
										<a href="">Anonymous Feedback</a>
									</li>
									<li>
										<a href="">Lorem Ipsum</a>
									</li>
								</ul>
							</div>

							<div class="footer-grid__cell footer-cell-address">
								<h6>Mailing Address</h6>

								<address>
									182 Howard Street #225<br>
									San Francisco, CA 94105
								</address>

								<h6>Email</h6>

								<a href="">info@openphilanthropy.org</a>

								<h6>Media Inquiries</h6>

								<a href="">media@openphilanthropy.org</a>
							</div>

							<div class="footer-grid__cell footer-cell-social">
								<h4>Sign Up to Follow Our Work</h4>

								<button>Join Our Mailing List</button>

								<div class="social-media">
									<ul>
										<li>
											<a href="">
												<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
											</a>
										</li>
										<li>
											<a href="">
												<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
											</a>
										</li>
									</ul>
								</div>

								<p class="copyright">
									&copy; Open Philanthropy 2021
								</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>