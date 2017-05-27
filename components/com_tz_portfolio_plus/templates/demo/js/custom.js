jQuery(document).ready(function(){
	jQuery('a[data-rel^="prettyPhoto"]').prettyPhoto({
		"hook": 'data-rel',
		"social_tools" : '',
		"theme": 'light_rounded'
	});
})