<script>
	function search() {
		var form = document.getElementById("formsubmit");
		var input = document.getElementById("searchPro");
		if (!form || !input) {
			return false;
		}
		var searchPro = $.trim($(input).val());
		if (searchPro.length >= 3) {
			form.submit();
			return true;
		}
		return false;
	}

	jQuery(function ($) {
		var $form = $("#formsubmit");
		if (!$form.length) {
			return;
		}
		$form.on("submit", function () {
			return $.trim($("#searchPro").val()).length >= 3;
		});
	});
</script>
<style>
	.login {
		border: 1px solid #2889c9;
		padding: 6px 8px;
		border-radius: 12px;
		color: #2889c9;
		margin-right: 10px !important;
	}

	.mega-dropdown-menu {
		padding: 18px 16px 22px;
		width: 100%;
		background: linear-gradient(135deg, #f3f9ff 0%, #eaf4fb 100%);
		border: 1px solid rgba(40, 137, 201, 0.22);
		border-top: 3px solid #2889c9;
		border-radius: 0 0 18px 18px;
		box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		box-sizing: border-box;
		max-height: calc(100vh - 170px);
		overflow-y: auto;
		scrollbar-width: thin;
		scrollbar-color: rgba(40, 137, 201, 0.55) rgba(255, 255, 255, 0.65);
	}

	.mega-dropdown-menu::-webkit-scrollbar {
		width: 8px;
	}
	.mega-dropdown-menu::-webkit-scrollbar-track {
		background: rgba(255, 255, 255, 0.65);
		border-radius: 10px;
	}
	.mega-dropdown-menu::-webkit-scrollbar-thumb {
		background: rgba(40, 137, 201, 0.55);
		border-radius: 10px;
	}

	.mega-dropdown-menu:before {
		content: "";
		border-bottom: 15px solid #fff;
		border-right: 17px solid transparent;
		border-left: 17px solid transparent;
		position: absolute;
		top: -15px;
		left: 285px;
		z-index: 10;
	}

	.mega-dropdown-menu:after {
		content: "";
		border-bottom: 17px solid #ccc;
		border-right: 19px solid transparent;
		border-left: 19px solid transparent;
		position: absolute;
		top: -17px;
		left: 283px;
		z-index: 8;
	}

	.mega-dropdown-menu>li>ul {
		padding: 0;
		margin: 0;
	}

	.mega-dropdown-menu>li>ul>li {
		list-style: none;
	}

	.mega-dropdown-menu>li>ul>li>a {
		display: block;
		padding: 3px 20px;
		clear: both;
		font-weight: normal;
		line-height: 1.428571429;
		color: #999;
		white-space: normal;
	}

	.mega-dropdown-menu>li ul>li>a:hover,
	.mega-dropdown-menu>li ul>li>a:focus {
		text-decoration: none;
		color: #444;
		background-color: #f5f5f5;
	}

	.mega-dropdown-menu .dropdown-header {
		color: #428bca;
		font-size: 18px;
		font-weight: bold;
	}

	.mega-dropdown-menu form {
		margin: 3px 20px;
	}

	.mega-dropdown-menu .form-group {
		margin-bottom: 3px;
	}

	/* Match the dropdown panel accent with the current Products nav text color */
	.mega-dropdown > a.hover-blue + .mega-dropdown-menu {
		border-top-color: #2889c9;
		box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
	}

	.mega-dropdown > a.hover-yellow + .mega-dropdown-menu {
		border-color: rgba(244, 196, 0, 0.28);
		border-top-color: #f4c400;
		box-shadow: 0 14px 36px rgba(244, 196, 0, 0.22), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(244, 196, 0, 0.22), 0 4px 12px rgba(0, 51, 102, 0.08);
	}

	.mega-dropdown-menu > li.col-sm-3 {
		border: 1px solid rgba(40, 137, 201, 0.14);
		border-radius: 14px;
		box-shadow: 0 4px 12px rgba(0, 51, 102, 0.06);
		padding: 14px 16px;
		transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease, background 0.22s ease;
	}
	.mega-dropdown-menu > li.col-sm-3:nth-child(odd) {
		background: linear-gradient(180deg, #ffffff 0%, #f1f8ff 100%);
		border-color: rgba(40, 137, 201, 0.24);
	}
	.mega-dropdown-menu > li.col-sm-3:nth-child(even) {
		background: linear-gradient(180deg, #ffffff 0%, #fff9df 100%);
		border-color: rgba(244, 196, 0, 0.34);
	}

	.mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(40, 137, 201, 0.42);
		box-shadow: 0 10px 24px rgba(40, 137, 201, 0.16);
		transform: translateY(-2px);
	}
	.mega-dropdown-menu > li.col-sm-3:nth-child(even):hover {
		border-color: rgba(244, 196, 0, 0.48);
		box-shadow: 0 10px 24px rgba(244, 196, 0, 0.18);
	}

	.mega-dropdown > a.hover-yellow + .mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(244, 196, 0, 0.48);
		box-shadow: 0 10px 24px rgba(244, 196, 0, 0.18);
	}

	.mega-dropdown > a.hover-blue + .mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(40, 137, 201, 0.42);
		box-shadow: 0 10px 24px rgba(40, 137, 201, 0.16);
	}

	@media (min-width: 768px) {
		.navbar-right .dropdown-menu {
			width: min(1280px, calc(100vw - 32px)) !important;
			margin-right: 0;
		}
	}

	.mega-dropdown-menu>li>ul>li>a {
		/* color: #777; */
		color: black;


	}

	.mega-dropdown-menu>li ul>li>a:hover,
	.mega-dropdown-menu>li ul>li>a:focus {
		text-decoration: none;
		color: #2889c9;
	}

	.mega-dropdown-menu .dropdown-header {
		color: #2889c9;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: 0.02em;
		padding-bottom: 7px;
		margin: 4px 0 6px;
		border-bottom: 1px solid rgba(40, 137, 201, 0.16);
		cursor: pointer;
	}

	.dropdown-menu {
		font-size: 11px;
	}

	.durotech_product {
		padding-top: 4%;
	}

	.mobilemenu {
		display: none !important;
	}
	.mobile-products-accordion {
		display: none;
		margin: 0 10px 12px;
		padding: 8px;
		list-style: none;
		background: linear-gradient(135deg, #f3f9ff 0%, #fff 100%);
		border: 1px solid rgba(40, 137, 201, 0.18);
		border-radius: 14px;
		box-shadow: 0 8px 22px rgba(0, 51, 102, 0.08);
		max-height: 65vh;
		overflow-y: auto;
	}
	.mobilemenu.is-open .mobile-products-accordion {
		display: block;
	}
	.mobile-products-toggle {
		display: flex !important;
		align-items: center;
		justify-content: space-between;
	}
	.mobile-products-icon {
		width: 22px;
		height: 22px;
		border-radius: 50%;
		background: rgba(40, 137, 201, 0.12);
		color: #2889c9;
		font-weight: 700;
		line-height: 22px;
		text-align: center;
		transition: transform 0.22s ease, background-color 0.22s ease;
	}
	.mobilemenu.is-open .mobile-products-icon {
		background: rgba(244, 196, 0, 0.2);
		transform: rotate(45deg);
	}
	.mobile-product-category {
		list-style: none;
		border-bottom: 1px solid rgba(40, 137, 201, 0.1);
	}
	.mobile-product-category:last-child {
		border-bottom: 0;
	}
	.mobile-product-category-toggle {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 8px;
		padding: 10px 8px 10px 12px;
		background: transparent;
		border: 0;
		color: #2889c9;
		font-size: 12px;
		font-weight: 700;
		text-align: left;
	}
	.mobile-product-category-toggle:after {
		content: "+";
		width: 20px;
		height: 20px;
		flex: 0 0 20px;
		border-radius: 50%;
		background: rgba(40, 137, 201, 0.1);
		color: #2889c9;
		line-height: 20px;
		text-align: center;
	}
	.mobile-product-category.is-open > .mobile-product-category-toggle:after {
		content: "-";
		background: rgba(244, 196, 0, 0.22);
		color: #b58a00;
	}
	.mobile-product-list {
		display: none;
		margin: 0;
		padding: 0 0 8px;
		list-style: none;
	}
	.mobile-product-category.is-open > .mobile-product-list {
		display: block;
	}
	.mobile-product-list a {
		display: block;
		margin: 2px 0;
		padding: 7px 10px 7px 22px;
		border-radius: 10px;
		color: #333;
		font-size: 12px;
		line-height: 1.35;
		text-decoration: none !important;
	}
	.mobile-product-list a:hover,
	.mobile-product-list a:focus,
	.mobile-product-list a.is-current,
	.mobile-product-category-toggle.is-current {
		background: linear-gradient(90deg, rgba(40, 137, 201, 0.14), rgba(244, 196, 0, 0.12));
		color: #0056b3 !important;
		font-weight: 700;
	}
	.mobile-view-category {
		color: #2889c9 !important;
		font-weight: 700;
	}

	@media (max-width: 767px) {
		.mobilemenu {
			display: block !important;
		}
	.header_top_address ul {
		list-style: none;       /* remove bullets */
		padding-left: 15px;
		margin: 0;
		display: flex;          /* put items in one line */
		flex-wrap: wrap;        /* wrap if screen is small */
		gap: 5px;              /* spacing between items */
		align-items: center;    /* align vertically with icons */
	}

	.header_top_address li {
		display: inline-flex;   /* inline with icon */
		align-items: center;
	}

	.header_top_address li i {
		margin-right: 5px;      /* spacing between icon and text */
		color: #444;            /* optional: style map icon */
	}

	.header_top_address a {
		font-weight: bold;      /* match your UI style */
		text-decoration: none;
		color: #0073e6;         /* link color */
	}

	.header_top_address a:hover {
		text-decoration: underline;  /* hover effect */
	}


		.desktop {
			display: none !important;
		}
	#header_top,
	.header_fixed {
		overflow: visible !important;
	}
	/* Mobile: center hamburger vertically with logo (Bootstrap float + toggle margins skew alignment) */
	#header_top .navbar-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		float: none;
		width: 100%;
		margin: 0;
	}
	#header_top .navbar-header::before,
	#header_top .navbar-header::after {
		display: none !important;
		content: none !important;
	}
	#header_top .navbar-toggle {
		float: none;
		order: 2;
		margin: 0;
		flex-shrink: 0;
		align-self: center;
	}
	#header_top .navbar-brand {
		float: none;
		order: 1;
		height: auto;
		padding-top: 0;
		padding-bottom: 0;
		margin: 0;
		flex: 1 1 auto;
		min-width: 0;
		align-self: center;
	}
	}
	#header_top.header_fixed {
		padding-top: 0;
		background: #f4f4f4;
		box-shadow: 0 1px 3px rgba(0,0,0,0.08);
	}
	.container.example5,
	.container.example5 .navbar,
	.container.example5 .navbar-header,
	.example5 .navbar-brand {
		overflow: visible !important;
	}
	.example5 .navbar-brand {
		align-items: center;
		display: flex !important;
	}
	.example5 .navbar-brand > img {
		object-fit: contain;
		object-position: center;
		width: auto;
		height: auto;
		max-height: 52px;
		display: block;
	}
	@media (min-width: 768px) {
		.example5 .navbar-brand > img {
			max-height: 68px;
		}
	}
	/* When scrolled: hide entire top bar (address + search + social); only logo + menu stay visible at top */
	.header_top.scrolled {
		display: none !important;
	}
	/* When scrolled: solid background for logo section so banner doesn't show through */
	.header_top.scrolled + .container.example5 {
		overflow: visible !important;
		background: #f4f4f4;
	}
	.header_top.scrolled + .container.example5 .navbar {
		overflow: visible !important;
		margin-bottom: 0;
	}
	.header_top.scrolled + .container.example5 .navbar-header,
	.header_top.scrolled + .container.example5 .navbar-brand {
		overflow: visible !important;
	}
	/* Unused when top bar hidden; kept for consistency */
	.header_top.scrolled .header_top_social_search {
		padding: 0 10px !important;
		margin-left: 0;
	}
	.header_top.scrolled .header_top_social_search form {
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.header_top.scrolled #searchPro {
		max-height: 36px;
		padding: 6px 10px;
		font-size: 14px;
		width: 100% !important;
		max-width: 220px;
	}
	.header_top.scrolled .header_top_social_search a i {
		font-size: 16px;
	}
	.navbar-collapse {
		overflow: visible !important;
	}
	/* Remove gap between top bar and logo section (fixes space when scroll down then back up) */
	#header_top.header_fixed .header_top {
		margin-bottom: 0 !important;
		padding-bottom: 6px !important;
	}
	#header_top.header_fixed .header_top .row {
		margin-bottom: 0 !important;
	}
	#header_top.header_fixed .container.example5 {
		margin-top: 0 !important;
		background: #f4f4f4;
		padding-top: 6px;
		padding-bottom: 6px;
	}
	#header_top.header_fixed .navbar.navbar-default {
		background-color: #f4f4f4 !important;
		background-image: none !important;
		border: none !important;
		border-radius: 0 !important;
		margin-bottom: 0 !important;
		box-shadow: none !important;
	}
	#header_top.header_fixed .navbar-default .navbar-collapse,
	#header_top.header_fixed .navbar-default .navbar-form {
		border-color: transparent !important;
		box-shadow: none !important;
	}
	#header_top.header_fixed .container-fluid,
	#header_top.header_fixed .navbar-header {
		background-color: #f4f4f4;
	}
	#header_top.header_fixed .container.example5 .navbar {
		background: #f4f4f4 !important;
		margin-bottom: 0;
		padding-top: 0;
		padding-bottom: 0;
	}
	/* Address section – same white as logo section so header looks consistent */
	.header_top {
		overflow: visible !important;
		padding-left: 12px;
		padding-right: 12px;
		background: #f4f4f4;
	}
	/* Counteract Bootstrap .row negative margins so the first map pin is not clipped */
	.header_top .row {
		overflow: visible !important;
	}
	.header_top_address {
		padding: 0 10px 0 6px;
		background: transparent;
		margin: 0;
		overflow: visible;
	}
	.header_top_address ul {
		list-style: none;
		padding: 0;
		padding-left: 6px;
		margin: 0;
		display: flex;
		flex-wrap: wrap;
		gap: 4px 8px;
		align-items: center;
		overflow: visible;
	}
	.header_top_address li {
		display: inline-flex;
		align-items: center;
		font-size: 12px;
	}
	/* Icons: black/dark like in reference */
	.header_top_address li i.fa-map-marker,
	.header_top_address li i.fa-envelope {
		margin-right: 3px;
		color: #1a1a1a;
		font-size: 12px;
	}
	/* Links & text: vibrant blue like in reference */
	.header_top_address a {
		font-weight: 700;
		text-decoration: none;
		color: #2672EC;
		transition: color 0.2s ease;
	}
	.header_top_address a:hover {
		color: #1a5bc4;
		text-decoration: none;
	}
	.header_top_address li Strong {
		color: #2672EC;
		font-weight: 700;
		margin-right: 4px;
	}
	.header_top_contact {
		padding: 0 35px 0 6px;
		text-align: right;
	}
	.header_top_contact ul {
		list-style: none;
		margin: 0 0 0 auto;
		padding: 0;
		max-width: 100%;
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: flex-end;
		align-items: center;
		gap: 3px 8px;
	}
	.header_top_contact li {
		margin: 0;
		padding: 0;
		list-style: none;
		line-height: 1.2;
	}
	.header_top_contact a {
		display: inline-flex;
		align-items: center;
		gap: 3px;
		font-size: 12px;
		font-weight: 600;
		color: #2672EC !important;
		text-decoration: none !important;
		white-space: nowrap;
	}
	.header_top_contact a:hover {
		color: #1a5bc4 !important;
	}
	.header_top_contact .fa-phone,
	.header_top_contact .fa-envelope {
		color: #1a1a1a;
		font-size: 12px;
		flex-shrink: 0;
	}
	/* Full state names: one row from tablet up (wider location column + compact search) */
	@media (min-width: 768px) {
		.header_top_address ul {
			flex-wrap: nowrap;
			gap: 2px 6px;
			padding-left: 8px;
		}
		.header_top_address li {
			flex-shrink: 0;
			white-space: nowrap;
		}
		.header_top_contact ul {
			justify-content: flex-end;
		}
	}
	@media (min-width: 1200px) {
		.header_top_address li {
			font-size: 12px;
		}
		.header_top_address li i.fa-map-marker {
			font-size: 12px;
		}
		.header_top_contact a {
			font-size: 12px;
		}
		.header_top_contact .fa-phone,
		.header_top_contact .fa-envelope {
			font-size: 12px;
		}
	}
	/* Narrower search so phone + email fit one line on the right */
	@media (min-width: 768px) {
		.header_top_social_search {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			padding-right: 4px;
		}
		.header_top_social_search form {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			width: 100%;
			max-width: 180px;
			margin-left: 0;
			margin-right: 0;
		}
		.header_top_social_search #searchPro {
			width: auto !important;
			max-width: 130px;
			min-width: 88px;
			flex: 1 1 auto;
		}
	}
	@media (min-width: 992px) {
		.header_top_social_search form {
			max-width: 200px;
		}
		.header_top_social_search #searchPro {
			max-width: 150px;
		}
	}
	@media (max-width: 767px) {
		.header_top_address {
			margin: 0;
			padding: 0;
			padding-left: 10px;
			padding-right: 10px;
		}
		.header_top_address ul {
			gap: 8px 12px;
			justify-content: center;
			padding-left: 0;
		}
		.header_top_address li {
			font-size: 12px;
		}
		.header_top_contact {
			text-align: center;
			padding: 10px 10px 0;
		}
		.header_top_contact ul {
			align-items: center;
			justify-content: center;
		}
		.header_top_address {
			padding-left: 12px;
			padding-right: 12px;
		}
		.header_top_contact a {
			white-space: normal;
			justify-content: center;
		}
		.header_top_social_search {
			display: flex;
			justify-content: center;
			padding: 6px 12px 0;
		}
		.header_top_social_search form {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			max-width: 245px;
			margin: 0 auto;
		}
		.header_top_social_search #searchPro {
			max-width: none !important;
			width: calc(100% - 28px) !important;
			flex: 1 1 auto;
		}
	}

	/* Prevent logo/nav from ever being clipped (fixed header) – keep original size */
	/* Keep header content below viewport top so logo/nav don’t get cut off */
	/* Compact search row when address is hidden (scrolled) */
	/* new_code for UI */

	/* ===== OPEN PRODUCTS MENU ON HOVER ===== */
		.navbar-nav > li.dropdown.mega-dropdown:hover > .dropdown-menu {
			display: block !important;
		}

		/* Keep menu open when moving mouse inside */
		.mega-dropdown:hover {
			display: block !important;
		}

		/* Main nav: no border/shadow until hover (JS adds .hover-blue / .hover-yellow) */
		#navbar5 .navbar-nav > li > a {
			border: 1px solid transparent;
			box-shadow: none;
			border-radius: 10px;
			transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
		}

		/* FORCE CUSTOM HOVER COLORS */
		.navbar-nav > li > a.hover-blue {
			background-color: rgba(0, 86, 179, 0.15) !important;
			border: 1px solid rgba(0, 86, 179, 0.4);
			box-shadow: 0 4px 14px rgba(20, 33, 61, 0.12);
			color: #0056b3 !important;
		}

		.navbar-nav > li > a.hover-yellow {
			background-color: rgba(244, 196, 0, 0.15) !important;
			border: 1px solid rgba(244, 196, 0, 0.4);
			box-shadow: 0 4px 14px rgba(20, 33, 61, 0.12);
			color: #f4c400 !important;
		}


		/* ===== OPEN PRODUCTS MEGA MENU ON HOVER ===== */
		.navbar-nav > li.dropdown.mega-dropdown:hover > .dropdown-menu {
			display: block !important;
			animation: megaMenuFadeIn 0.22s ease both;
		}

		@keyframes megaMenuFadeIn {
			from {
				opacity: 0;
				transform: translateY(8px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		

	/* Remove dots (bullets) from mega dropdown menu */
	.mega-dropdown-menu ul,
	.mega-dropdown-menu li {
		list-style: none !important;
	}

	.nav > li > a {
		line-height: 30px;
	}

	/* 30-12-2025 */

	/* For dropdown headers */
	.mega-dropdown-menu .dropdown-header,
	.mega-dropdown-menu a {
		white-space: nowrap;         /* Prevent text wrapping */
		overflow: hidden;            /* Hide overflow */
		text-overflow: ellipsis;     /* Show ... for long text */
		display: block;              /* Ensure proper width applies */
		padding-right: 10px;         /* Keep some space on the right */
	}

	.mega-dropdown-menu .dropdown-header {
		position: relative;
		padding-left: 14px;
	}

	.mega-dropdown-menu .dropdown-header::before {
		content: "";
		position: absolute;
		left: 0;
		top: 8px;
		width: 4px;
		height: 18px;
		border-radius: 999px;
		background: linear-gradient(180deg, #2889c9 0%, #f4c400 100%);
	}

	/* Optional: fix width of column */
	.mega-dropdown-menu li.col-sm-3 ul {
		width: 100%; /* or a fixed px value like 200px */
	}


	/* Base hover style */
	.mega-dropdown-menu li a,
	.mega-dropdown-menu .dropdown-header {
		display: block;
		padding: 6px 10px;
		border: 1px solid transparent;
		transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease, background-color 0.22s ease;
		border-radius: 10px;
		cursor: pointer;

	
	}

	.mega-dropdown-menu li a {
		font-size: 11px;
		line-height: 1.55;
		position: relative;
		padding-left: 18px;
	}

	.mega-dropdown-menu li a::before {
		content: "\203A";
		position: absolute;
		left: 7px;
		top: 50%;
		transform: translateY(-50%) translateX(-4px);
		opacity: 0;
		transition: opacity 0.22s ease, transform 0.22s ease;
	}

	.mega-dropdown-menu li a:hover::before,
	.mega-dropdown-menu li a:focus::before,
	.mega-dropdown-menu li a.is-current::before,
	.mega-dropdown-menu li a.hover-blue::before,
	.mega-dropdown-menu li a.hover-yellow::before {
		opacity: 1;
		transform: translateY(-50%) translateX(0);
	}

	/* Interactive menu-card hover, preserving old blue/yellow alternating colors */
	.mega-dropdown-menu li a:hover,
	.mega-dropdown-menu li a:focus,
	.mega-dropdown-menu .dropdown-header:hover,
	.mega-dropdown-menu .dropdown-header:focus {
		background: rgba(255, 255, 255, 0.72) !important;
		border-color: rgba(40, 137, 201, 0.25);
		box-shadow: 0 6px 16px rgba(0, 51, 102, 0.12);
		transform: translateX(3px);
		text-decoration: none;
	}
	.mega-dropdown-menu li a.is-current,
	.mega-dropdown-menu .dropdown-header.is-current {
		background: linear-gradient(90deg, rgba(40, 137, 201, 0.14), rgba(244, 196, 0, 0.12)) !important;
		border-color: rgba(40, 137, 201, 0.38);
		box-shadow: 0 6px 16px rgba(40, 137, 201, 0.14);
		color: #0056b3 !important;
		font-weight: 700;
	}

	.hover-blue {
		background-color: rgba(0, 86, 179, 0.15);  /* semi-transparent brand blue */
		border: 1px solid rgba(0, 86, 179, 0.4);  /* subtle border */
		color: #0056b3 !important;                /* brand blue text */
	}

	/* Subtle Yellow highlight */
	.hover-yellow {
		background-color: rgba(244, 196, 0, 0.15); /* semi-transparent brand yellow */
		border: 1px solid rgba(244, 196, 0, 0.4); /* subtle border */
		color: #f4c400 !important;                /* brand yellow text */
	}




	.state-link {
    padding: 1px 4px;
    border-radius: 8px;
    transition: all 0.25s ease;
	}

	/* Hover = live read preview */
	.state-link:hover {
		background: rgba(0, 86, 179, 0.15);
		color: #0056b3;
	}

	/* Active (clicked) */
	.state-link.active {
		background: rgba(52, 199, 89, 0.2); /* subtle green */
		border: 1px solid rgba(52, 199, 89, 0.6);
		color: #1c7c3c;
	}

	@media (min-width: 768px) {
		.navbar-nav > li.dropdown.mega-dropdown:hover > .mega-dropdown-menu {
			display: flex !important;
		}
		.mega-dropdown-menu.row {
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		.mega-dropdown-menu {
			flex-wrap: wrap;
			align-items: flex-start;
			gap: 20px;
			padding-left: 24px;
			padding-right: 24px;
		}
		.mega-dropdown-menu > li.col-sm-3 {
			float: none !important;
			width: calc(20% - 16px) !important;
			box-sizing: border-box;
			min-width: 0;
		}
	}




</style>
<script>
	jQuery(document).on('click', '.mega-dropdown', function(e) {
		e.stopPropagation()
	})
</script>
<?php
// $getCategories is set in AppController::beforeFilter() (requestAction would crash: actions must return Response|null)
if (!isset($getCategories)) {
    $getCategories = [];
}
$currentMenuPass = $this->request->getParam('pass') ?: [];
$currentMenuSlug = $this->request->getQuery('slug') ?? $this->request->getParam('slug') ?? ($currentMenuPass[0] ?? '');
$currentMenuSlug = is_string($currentMenuSlug) ? trim(rawurldecode($currentMenuSlug)) : '';
$currentMenuController = $this->request->getParam('controller');
$currentMenuAction = $this->request->getParam('action');
$currentMenuIsCategory = ($currentMenuController === 'Products' && $currentMenuAction === 'index' && $currentMenuSlug !== '');
$currentMenuIsProduct = ($currentMenuController === 'Products' && $currentMenuAction === 'detail' && $currentMenuSlug !== '');

?>
<div class="header_fixed col-lg-12 col-md-12 col-sm-12" id="header_top">
	<div class="container example5">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar5">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo_new.png" alt="Durotech — Commercial waterproofing and sealants, Australian Made and Owned">
					</a>
				</div>
				<div id="navbar5" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<!--li class="active"><a href="<?php echo SITEURL ?>">Home</a></li-->
						<li><a href="<?php echo SITEURL ?>">Home</a></li>
						<li><a href="<?php echo SITEURL ?>about">About Us</a></li>
						<li><a href="<?php echo SITEURL ?>projects">Projects</a></li>
						<!-- <li><a href="<?php //echo SITEURL ?>testimonials">Testimonials</a></li> -->


						<li class="mobilemenu<?php echo ($currentMenuIsCategory || $currentMenuIsProduct) ? ' is-open' : ''; ?>">
							<a href="javascript:void(0)" class="mobile-products-toggle" aria-expanded="<?php echo ($currentMenuIsCategory || $currentMenuIsProduct) ? 'true' : 'false'; ?>">
								Products <span class="mobile-products-icon">+</span>
							</a>
							<ul class="mobile-products-accordion">
								<?php if (!empty($getCategories) && is_array($getCategories)): ?>
									<?php foreach ($getCategories as $cat): ?>
										<?php
										if (empty($cat['Category']['category_name'])) {
											continue;
										}
										$categorySlug = $cat['Category']['slug'] ?? '';
										$hasCurrentProduct = false;
										if ($currentMenuIsProduct && !empty($cat['Product']) && is_array($cat['Product'])) {
											foreach ($cat['Product'] as $prodForActive) {
												if (($prodForActive['slug'] ?? '') === $currentMenuSlug) {
													$hasCurrentProduct = true;
													break;
												}
											}
										}
										$categoryIsCurrent = ($currentMenuIsCategory && $categorySlug === $currentMenuSlug) || $hasCurrentProduct;
										?>
										<li class="mobile-product-category<?php echo $categoryIsCurrent ? ' is-open' : ''; ?>">
											<button type="button" class="mobile-product-category-toggle<?php echo $categoryIsCurrent ? ' is-current' : ''; ?>" aria-expanded="<?php echo $categoryIsCurrent ? 'true' : 'false'; ?>">
												<?php echo h($cat['Category']['category_name']); ?>
											</button>
											<ul class="mobile-product-list">
												<li><a class="mobile-view-category<?php echo $currentMenuIsCategory && $categorySlug === $currentMenuSlug ? ' is-current' : ''; ?>" href="<?php echo $this->Url->build('/category/' . $categorySlug); ?>">View Category</a></li>
												<?php if (!empty($cat['Product']) && is_array($cat['Product'])): ?>
													<?php foreach ($cat['Product'] as $product): ?>
														<?php if (!empty($product['slug'])): ?>
															<li>
																<a class="<?php echo $currentMenuIsProduct && ($product['slug'] ?? '') === $currentMenuSlug ? 'is-current' : ''; ?>" href="<?= $this->Url->build('/product/' . $product['slug']) ?>">
																	<?php echo h($product['title']); ?>
																</a>
															</li>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											</ul>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</li>
						<li class="dropdown mega-dropdown desktop">
							<!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#null">Products</a> -->
							<a class="dropdown-toggle"
								href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'categories']) ?>">
								Products
							</a>



							<ul class="dropdown-menu mega-dropdown-menu row">


							<?php
							// Split all categories into 5 columns so the right side is filled
							$totalCategories = count($getCategories);
							$categoriesPerColumn = max(1, (int)ceil($totalCategories / 5));
							$categoryChunks = array_chunk($getCategories, $categoriesPerColumn);
							?>

							<?php foreach ($categoryChunks as $column): ?>
								<li class="col-sm-3">
									<ul>
										<?php foreach ($column as $cat): ?>
											<?php
											$categorySlug = $cat['Category']['slug'] ?? '';
											$hasCurrentProduct = false;
											if ($currentMenuIsProduct && !empty($cat['Product'])) {
												foreach ($cat['Product'] as $productForActive) {
													if (($productForActive['slug'] ?? '') === $currentMenuSlug) {
														$hasCurrentProduct = true;
														break;
													}
												}
											}
											$categoryCurrentClass = ($currentMenuIsCategory && $categorySlug === $currentMenuSlug) || $hasCurrentProduct ? ' is-current' : '';
											?>
											<li class="dropdown-header rotate-text<?php echo $categoryCurrentClass; ?>" onclick="openlink('<?php echo h($categorySlug); ?>')">
												<?php echo h($cat['Category']['category_name']); ?>
											</li>
											<?php if (!empty($cat['Product'])): ?>
												<?php foreach ($cat['Product'] as $product): ?>
													<li>
														<a class="<?php echo $currentMenuIsProduct && ($product['slug'] ?? '') === $currentMenuSlug ? 'is-current' : ''; ?>" href="<?= $this->Url->build('/product/' . ($product['slug'] ?? '')) ?>">
															<?php echo h($product['title']); ?>
														</a>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
											<li class="divider"></li>
										<?php endforeach; ?>
									</ul>
								</li>
							<?php endforeach; ?>


							</ul>

						</li>
						<li><a href="<?php echo SITEURL ?>technical-literature">Technical literature</a></li>
						<!-- <li><a href="<?php echo SITEURL ?>specifiers">Specifiers</a></li> -->
						<!--li><a href="<?php echo SITEURL ?>video">Video</a></li-->
						<!--li><a href="https://duroshop.com">DuroShop</a></li-->
						<li><a href="<?php echo SITEURL ?>durolab">DuroLab</a></li>

						<!--li><a href="http://durotechpolymers.com">Durotech Polymers</a></li-->
						<li><a href="<?php echo SITEURL ?>contact">Contact Us</a></li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
			<!--/.container-fluid -->
		</nav>
	</div>
</div>
<script>
	function openlink(slug) {
		window.location.href = '<?= $this->Url->build('/category/') ?>' + slug;
	}

	jQuery(function ($) {
		$('.mobile-products-toggle').on('click', function (e) {
			e.preventDefault();
			var $menu = $(this).closest('.mobilemenu');
			$menu.toggleClass('is-open');
			$(this).attr('aria-expanded', $menu.hasClass('is-open') ? 'true' : 'false');
		});

		$('.mobile-product-category-toggle').on('click', function () {
			var $category = $(this).closest('.mobile-product-category');
			$category.toggleClass('is-open').siblings('.mobile-product-category').removeClass('is-open').children('.mobile-product-category-toggle').attr('aria-expanded', 'false');
			$(this).attr('aria-expanded', $category.hasClass('is-open') ? 'true' : 'false');
		});
	});

	jQuery(function ($) {
		var headerRoot = document.getElementById("header_top");
		if (!headerRoot) {
			return;
		}
		function applyBannerTopPadding() {
			var h = Math.ceil(headerRoot.getBoundingClientRect().height);
			if (h < 1) {
				return;
			}
			var pad = h;
			var selectors = [
				".durotech .banner",
				".durotech .contact_banner",
				".durotech .banner_durolab",
				".durotech .page-about-wrap",
				".durotech .banner-section"
			];
			for (var s = 0; s < selectors.length; s++) {
				var nodes = document.querySelectorAll(selectors[s]);
				for (var i = 0; i < nodes.length; i++) {
					var el = nodes[i];
					if (el.classList && el.classList.contains("banner_durolab")) {
						var hasImg = el.querySelector && el.querySelector("img");
						var inner = (el.innerHTML || "").replace(/\s+/g, "");
						if (!hasImg && inner === "") {
							el.style.setProperty("padding-top", "0", "important");
							el.style.setProperty("margin-top", "0", "important");
							el.style.setProperty("min-height", "0", "important");
							continue;
						}
					}
					el.style.setProperty("padding-top", pad + "px", "important");
				}
			}
		}
		function syncLayout() {
			document.body.classList.add("header-top-bar-removed");
			applyBannerTopPadding();
		}
		window.addEventListener("resize", syncLayout, { passive: true });
		window.addEventListener("load", syncLayout, { passive: true });
		if (window.requestAnimationFrame) {
			requestAnimationFrame(function () {
				requestAnimationFrame(syncLayout);
			});
		} else {
			setTimeout(syncLayout, 0);
		}
		syncLayout();
	});

	//new_code
	$(".mega-dropdown").hover(
		function () {
			$(this).addClass("open");
		},
		function () {
			$(this).removeClass("open");
		}
	);


</script>

<script>
    let hoverToggle = true; // true = blue, false = yellow

    $('.mega-dropdown-menu').on(
        'mouseenter',
        'a, .dropdown-header',
        function () {
            if (hoverToggle) {
                $(this).addClass('hover-blue');
            } else {
                $(this).addClass('hover-yellow');
            }
            hoverToggle = !hoverToggle;
        }
    );

    $('.mega-dropdown-menu').on(
        'mouseleave',
        'a, .dropdown-header',
        function () {
            $(this).removeClass('hover-blue hover-yellow');
        }
    );
</script>
<script>
	let headerHoverToggle = true;

	$('.navbar-nav > li > a').on('mouseenter', function () {
		$(this).removeClass('hover-blue hover-yellow');

		if (headerHoverToggle) {
			$(this).addClass('hover-blue');
		} else {
			$(this).addClass('hover-yellow');
		}

		headerHoverToggle = !headerHoverToggle;
	});

	$('.navbar-nav > li > a').on('mouseleave', function () {
		$(this).removeClass('hover-blue hover-yellow');
	});
</script>

<script>
jQuery(document).ready(function () {
    jQuery('.state-link').on('click', function () {

        // remove active from all
        jQuery('.state-link').removeClass('active');

        // add active to clicked
        jQuery(this).addClass('active');

        // preview only (no blocking navigation)
        // If Kal says "don’t open map yet", uncomment below:
        // return false;
    });
});
</script>

<script>
jQuery(function ($) {
	function fitProductsMegaMenu() {
		var $menuItem = $('.mega-dropdown.desktop').first();
		var $menu = $menuItem.children('.mega-dropdown-menu');
		if (!$menuItem.length || !$menu.length) {
			return;
		}
		var viewportWidth = $(window).width();
		var menuWidth = Math.min(1280, viewportWidth - 32);
		var menuLeft = Math.max(16 - $menuItem.offset().left, (viewportWidth - menuWidth) / 2 - $menuItem.offset().left);
		$menu.css({
			width: menuWidth + 'px',
			left: menuLeft + 'px',
			right: 'auto',
			marginRight: 0
		});
	}
	$('.mega-dropdown.desktop').on('mouseenter', fitProductsMegaMenu);
	$(window).on('resize', fitProductsMegaMenu);
	fitProductsMegaMenu();
});
</script>


