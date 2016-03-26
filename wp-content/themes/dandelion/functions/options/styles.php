<?php


/**
 * Load the patterns into arrays.
 */
$patterns=array();
$patterns[0]='none';
for($i=1; $i<=32; $i++){
	$patterns[]='pattern'.$i.'.png';
}


$pexeto_styles_options=array(array(
"name" => "Style settings",
"type" => "title",
"img" => "icon-write"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"general", "name"=>"General"), array("id"=>"logo", "name"=>"Logo"), array("id"=>"text", "name"=>"Text Styles"), array("id"=>"bg", "name"=>"Backgrounds"), array("id"=>"fonts", "name"=>"Fonts"))
),

/* ------------------------------------------------------------------------*
 * GENERAL
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id" => 'general'
),

array(
"name" => "Predefined Skins",
"id" => $shortname."_skin",
"type" => "stylecolor",
"options" => array( "b0b0b0","919191","595959","9ab895","83988e","62786e","99b2b7","668284","547980","aaccb1","53777a","0e2430","bebd6d","88a65e","5e8c6a","ccb87d","897a53","6b675c","e3dfba","c5bc8e","696758","bca297","73626e","574951","a37e58","9d5c56","45484b","b38184","7b3b3b","542437"),
"std" => 'b0b0b0',
"desc" => 'You can either select a predefined skin or pick your custom color below.'
),

array(
"name" => "Custom Theme Color",
"id" => $shortname."_custom_skin",
"type" => "color",
"desc" => 'You can select a custom color for your theme. This field has priority over the "Predefined Skins" one. '
),

array(
"name" => "Theme Pattern",
"id" => $shortname."_pattern",
"type" => "pattern",
"options" => $patterns,
"desc" => 'You can either select one of the default patterns here or upload your own in the Custom Pattern field below.'
),

array(
"name" => "Custom Pattern",
"id" => $shortname."_custom_pattern",
"type" => "upload",
"desc" => 'You can upload your custom pattern image here.'
),

array(
"name" => "Main body text size",
"id" => $shortname."_body_text_size",
"type" => "text",
"desc" => "The main body font size in pixels. Default: 12"
),

array(
"name" => "Additional CSS styles",
"id" => $shortname."_additional_styles",
"type" => "textarea",
"desc" => "You can insert some more additional CSS code here."
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * LOGO OPTIONS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'logo'
),

array(
"name" => "Logo image",
"id" => $shortname."_logo_image",
"type" => "upload",
"desc" => "You can either use the Upload button to upload your custom logo image or insert the full
URL of the image, for example: http://site.com/image-name.jpg"
),

array(
"name" => "Logo image width",
"id" => $shortname."_logo_width",
"type" => "text",
"desc" => "The logo image width in pixels- default:160. It is recommended
		to set either the logo image width or logo image height, but not both so that
		the image is always displayed in its original ratio."
),


array(
"name" => "Logo image height",
"id" => $shortname."_logo_height",
"type" => "text",
"desc" => "The logo image height in pixels - by default the
		logo height would depend on the original logo image ratio. It is recommended
		to set either the logo image width or logo image height, but not both so that
		the image is always displayed in its original ratio."
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * TEXT STYLES
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'text',
),

array(
"name" => "Main body text color",
"id" => $shortname."_body_color",
"type" => "color",
"desc" => "This setting will change the main content and sidebar text color."
),

array(
"name" => "Headings color",
"id" => $shortname."_heading_color",
"type" => "color"
),

array(
"name" => "Page subtitle color",
"id" => $shortname."_subtitle_color",
"type" => "color",
"desc" => "The subtitle in the header section that is displayed when no slider has been selected."
),

array(
"name" => "Content slider text color",
"id" => $shortname."_content_text_color",
"type" => "color"
),

array(
"name" => "Links color",
"id" => $shortname."_link_color",
"type" => "color"
),

array(
"name" => "Menu links color",
"id" => $shortname."_menu_link_color",
"type" => "color"
),

array(
"name" => "Menu links hover color",
"id" => $shortname."_menu_link_hover",
"type" => "color",
"desc" => "This is the color of the menu links when the mouse cursor gets positioned over the link"
),

array(
"name" => "Footer text color",
"id" => $shortname."_footer_text_color",
"type" => "color"
),

array(
"name" => "Footer copyright text color",
"id" => $shortname."_copyright_text",
"type" => "color"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * BACKGROUNDS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id" => 'bg'
),

array(
"name" => "Body background color",
"id" => $shortname."_body_bg",
"type" => "color"
),

array(
"name" => "Page subtitle line background color",
"id" => $shortname."_subtitle_bg",
"type" => "color",
"desc" => "This is the thin line that is displayed on top of the page below the menu when no slider is selected for the page."
),

array(
"name" => "Content slider background color",
"id" => $shortname."_content_bg_color",
"type" => "color"
),

array(
"name" => "Lines and borders color",
"id" => $shortname."_border_color",
"type" => "color"
),

array(
"name" => "Pricing boxes background color",
"id" => $shortname."_boxes_color",
"type" => "color"
),

array(
"name" => "Comments background color",
"id" => $shortname."_comments_bg",
"type" => "color"
),

array(
"name" => "Footer background color",
"id" => $shortname."_footer_bg",
"type" => "color"
),

array(
"name" => "Footer copyright section background color",
"id" => $shortname."_copyright_bg",
"type" => "color"
),

array(
"name" => "Footer lines color",
"id" => $shortname."_footer_lines_color",
"type" => "color"
),


array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * FONTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id" => 'fonts'
),


array(
"type" => "documentation",
"text" => "<h3>Cufon Font Replacement</h3>"
),

array(
"name" => "Enable Cufon for headings",
"id" => $shortname."_enable_cufon",
"type" => "checkbox",
"std" => 'off',
"desc" => "If it is enabled, you will be able to use another custom fonts for the headings. You will be able to
either select one of the default fonts that the theme comes with or upload your own font below."
),

array(
"name" => "Heading Cufon Font",
"id" => $shortname."_cufon_font",
"type" => "select",
"options" => array(array('id'=>'andika.js','name'=>'Andika Basic'),array('id'=>'caviar_dreams.js','name'=>'Caviar Dreams'),array('id'=>'charis_sil.js','name'=>'Charis'),array('id'=>'chunk_five.js','name'=>'Chunk Five'),array('id'=>'comfortaa.js','name'=>'Comfortaa'),array('id'=>'droid_serif.js','name'=>'Droid Serif'), array('id'=>'kingthings_exeter.js','name'=>'Kingthings Exeter'), array('id'=>'luxy_sans.js','name'=>'Luxy Sans'), array('id'=>'sling.js','name'=>'Sling'), array('id'=>'vegur.js','name'=>'Vegur')),
"desc" => 'You can select one of the fonts that the theme goes with. In order the font to replace the default one
the "Enable Cufon" field above should be enabled.'
),

array(
"name" => "Custom Heading Font",
"id" => $shortname."_custom_cufon_font",
"type" => "upload",
"desc" => 'You can upload your custom JavaScript font file here. You can generate the font here: http://cufon.shoqolate.com/generate/'
),

array(
"type" => "documentation",
"text" => "<h3>Google API Fonts</h3>"
),


array(
"name" => "Enable Google Fonts",
"id" => PEXETO_SHORTNAME."_enable_google_fonts",
"type" => "checkbox",
"std" =>"off"
),

array(
"name"=>"Add Google Font",
"id"=>'google_fonts',
"type"=>"custom",
"button_text"=>'Add Font',
"fields"=>array(
	array('id'=>'pex_google_fonts_name', 'type'=>'textarea', 'name'=>'Font URL')
),
"desc"=>"In this field you can add or remove Google Fonts to the theme. Please note that only the font
URL should be inserted here (the value that is set within the 'href' attribute of the embed link tag Google provides), not the whole embed link tag.
<b>Example:</b><br />
http://fonts.googleapis.com/css?family=Lato<br />
<br />In order to enable the new font for the theme, simply add its name in the Font Family fields below."

),

array(
"type" => "documentation",
"text" => "<h3>Font Family</h3>"
),

array(
"name" => "Headings font family",
"id" => PEXETO_SHORTNAME."_heading_font_family",
"type" => "textarea",
"desc" => 'You can change the font family for the theme headings in this field. If you have loaded a Google API font,
you can insert its name here. 
<br />Notes:
<br />1. If the font name contains an empty space, you have to surround its name with quotation marks, for example: "Times New Roman"
<br />2. If Cufon font replacement is enabled above, the Cufon font selected will have higher priority than the fonts set in here
<br />3. The different font names should be separated by commas'
),

array(
"name" => "Body font family",
"id" => PEXETO_SHORTNAME."_body_font_family",
"type" => "textarea",
"desc" => 'You can change the main body font family for the theme in this field. If you have loaded a Google API font,
you can insert its name here. 
<br />Notes:
<br />1. If the font name contains an empty space, you have to surround its name with quotation marks, for example: "Times New Roman"
<br />2. The different font names should be separated by commas'
),



array(
"type" => "close"),


array(
"type" => "close"));

$pexeto_options_manager->add_options($pexeto_styles_options);