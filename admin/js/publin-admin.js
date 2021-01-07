(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *a
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( function() {
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var count = 0;
				$('#sortable li input[type=hidden].order').each(function(){
					count++;
					$(this).val(count);
				});
			}
		});
		$( "#sortable" ).disableSelection();

		$( "#sortableOrder1" ).sortable({
			connectWith: [
				"#sortableOrder2",
				"#sortableOrder3",
				"#sortableOrder4",
			],
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var count = 0;
				$('#sortableOrder1 li input[type=hidden].order').each(function(){
					count++;
					$(this).val(count);
				});

				$('#sortableOrder1 li input[type=hidden].column').each(function(){
					$(this).val(1);
				});
			}
		});
		$( "#sortableOrder1" ).disableSelection();

		$( "#sortableOrder2" ).sortable({
			connectWith: [
				"#sortableOrder1",
				"#sortableOrder3",
				"#sortableOrder4",
			],
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var count = 0;
				$('#sortableOrder2 li input[type=hidden].order').each(function(){
					count++;
					$(this).val(count);
				});

				$('#sortableOrder2 li input[type=hidden].column').each(function(){
					$(this).val(2);
				});
			}
		});
		$( "#sortableOrder2" ).disableSelection();
		
		$( "#sortableOrder3" ).sortable({
			connectWith: [
				"#sortableOrder1",
				"#sortableOrder2",
				"#sortableOrder4",
			],
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var count = 0;
				$('#sortableOrder3 li input[type=hidden].order').each(function(){
					count++;
					$(this).val(count);
				});

				$('#sortableOrder3 li input[type=hidden].column').each(function(){
					$(this).val(3);
				});
			}
		});
		$( "#sortableOrder3" ).disableSelection();
		
		$( "#sortableOrder4" ).sortable({
			connectWith: [
				"#sortableOrder1",
				"#sortableOrder2",
				"#sortableOrder3",
			],
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var count = 0;
				$('#sortableOrder4 li input[type=hidden].order').each(function(){
					count++;
					$(this).val(count);
				});

				$('#sortableOrder4 li input[type=hidden].column').each(function(){
					$(this).val(4);
				});
			}
		});
		$( "#sortableOrder4" ).disableSelection();
	  } );

	  jQuery(document).ready(function($){
		$('.my-color-field').wpColorPicker();
	});

	  

})( jQuery );
