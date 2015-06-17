all:
	open http://localhost/cm
	subl  wp-content/themes/cm
	sass --watch wp-content/themes/cm/assets/css/style.scss:wp-content/themes/cm/assets/css/style.css