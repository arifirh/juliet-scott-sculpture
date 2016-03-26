/**
 * This is the JS file for the page add/edit section
 *
 * Author: Pexeto http://pexeto.com/
 */

var pexetoPageOptions;

(function($) {

	pexetoPageOptions = {

		/**
		 * Loads the names of the sliders that correspond to the selected slider only.
		 */
		setSliderFields: function() {
			//load the slider names with the initial page load
			var savedClass, 
				$sliderTypeField = $('#slider_value'),
				$sliderNameField = $('#slider_name_value'),
				$options = $sliderNameField.find("option").not(".caption").clone(),
				
				loadSelectedSliderNames = function(){
					var selectedClass = $sliderTypeField.find('option:selected').attr('class'),
						$selectedOptions = $options.filter("." + selectedClass);

					if($selectedOptions.length) {
						//add the selected items only and enable the field if it is disabled
						$sliderNameField.removeAttr('disabled')
							.empty()
							.append($selectedOptions);
					} else {
						//disable the drop down if no slider names correspond to the selected option
						$sliderNameField.empty()
							.append('<option>None</option>')
							.attr('disabled', 'disabled');
					}
				};

			loadSelectedSliderNames ();
			$sliderTypeField.on("change", loadSelectedSliderNames);
			
		}
		
	};

}(jQuery));

jQuery(function() {
	pexetoPageOptions.setSliderFields();
});