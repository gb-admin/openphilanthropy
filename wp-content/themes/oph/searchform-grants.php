<form class="search-form" action="/" method="get">
	<label for="search-grants">Search in Grants</label>

	<input class="search-field" id="search-grants" type="search" name="s" placeholder="Search" value="<?php the_search_query(); ?>">

	<input type="hidden" name="post_type" value="grants">

	<button type="submit">
		<svg aria-hidden="true" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg"><path d="M16.478 13.675c2.273-3.305 1.94-7.862-.998-10.801-3.314-3.314-8.687-3.314-12 0-3.314 3.314-3.314 8.686 0 12 3.207 3.208 8.345 3.31 11.676.308l4.429 4.429 1.414-1.414-4.521-4.522zm-2.413-9.387c2.533 2.533 2.533 6.64 0 9.172-2.532 2.533-6.639 2.533-9.171 0-2.533-2.533-2.533-6.64 0-9.172 2.532-2.533 6.639-2.533 9.171 0z"/></svg>
	</button>
</form>