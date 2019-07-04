<?php

	/**
	 * @package Region Halland ACF Page RSS Link
	 */
	/*
	Plugin Name: Region Halland ACF Page RSS Link
	Description: ACF-fält för länk till RSS-flöde
	Version: 1.3.0
	Author: Roland Hydén
	License: MIT
	Text Domain: regionhalland
	*/

		// Anropa function om ACF är installerad
	add_action('acf/init', 'my_acf_add_page_rss_link_field_groups');

	// Function för att lägga till "field groups"
	function my_acf_add_page_rss_link_field_groups() {

		// Om funktionen existerar
		if (function_exists('acf_add_local_field_group')):

			// Skapa formlärfält
			acf_add_local_field_group(array(
			    
			    'key' => 'group_1000204',
			    'title' => 'RSS-flöde',
			    'fields' => array(
			        0 => array(
					    'key' => 'field_1000205',
					    'label' => 'Namn på RSS-flöde',
					    'name' => 'name_1000206',
					    'type' => 'text',
					    'instructions' => '',
					    'required' => 0,
					    'conditional_logic' => 0,
					    'wrapper' => [
					        'width' => '',
					        'class' => '',
					        'id' => '',
					    ],
					    'default_value' => '',
					    'placeholder' => '',
					    'prepend' => '',
					    'append' => '',
					    'maxlength' => '',
			        ),
			        1 => array(
					    'key' => 'field_1000207',
					    'label' => 'Url till RSS-flöde',
					    'name' => 'name_1000208',
					    'type' => 'url',
					    'instructions' => '',
					    'required' => 0,
					    'conditional_logic' => 0,
					    'wrapper' => [
					        'width' => '',
					        'class' => '',
					        'id' => '',
					    ],
					    'default_value' => '',
					    'placeholder' => '',
			        ),
			        2 => array(
			        	'key' => 'field_1000209',
					    'label' => 'Antal rss-poster',
					    'name' => 'name_1000210',
					    'type' => 'number',
					    'instructions' => 'Ange antal rss-poster',
					    'required' => 0,
					    'conditional_logic' => 0,
					    'wrapper' => [
					        'width' => '',
					        'class' => '',
					        'id' => '',
					    ],
					    'default_value' => '',
					    'placeholder' => '',
					    'prepend' => '',
					    'append' => '',
					    'min' => '',
					    'max' => '',
					    'step' => '',
			        ),
			    ),
			    'location' => array(
			        0 => array(
			            0 => array(
			                'param' => 'post_type',
			                'operator' => '==',
			                'value' => 'page',
			            ),
			        )
			    ),
			    'menu_order' => 0,
			    'position' => 'normal',
			    'style' => 'default',
			    'label_placement' => 'top',
			    'instruction_placement' => 'label',
			    'hide_on_screen' => '',
			    'active' => 1,
			    'description' => '',
			));

		endif;

	}

	// Hämta ut rss-länkar
	function get_region_halland_acf_page_rss_link_items() {
		
		// Rss-url
		$myRssUrl = get_field('name_1000208');
		
		// Kontrolelra om det finns en angiven url
		if ($myRssUrl) {

			// Kontrollera om denna url existerar
			// OBS! Bara kontroll av den första byten, inte hela filen
			if (@file_get_contents($myRssUrl,false,NULL,0,1)) {
				
				// Allting ok 
				$doRss = 1;

			} else {

				// Filen finns inte
				$doRss = 0;
			
			}

		} else {
			
			// Url finns inte
			$doRss = 0;
		
		}

	    // Array för att samla ihop data
		$myData = array();
		
		// Om det finns en angiven url
		if ($doRss == 1) {

			// Rss-sidans title
			$myRssTitle = get_field('name_1000206');

			// Hur många poster som ska visas
			$myRssAntal = intval(get_field('name_1000210'));

			// Tmp-array för feeds
		    $myFeeds = array();

		    // Räknare
		    $myAntal = 0;

		    // Koppla upp nytt DOM-document
			$myRss = new DOMDocument();
		    $myRss->load($myRssUrl);

		    // Loopa igenom alla poster
		    foreach ($myRss->getElementsByTagName('item') as $myNode) {
		        $myItem = array ( 
		            'title' => $myNode->getElementsByTagName('title')->item(0)->nodeValue,
		            'link' => $myNode->getElementsByTagName('link')->item(0)->nodeValue,
		            'description' => $myNode->getElementsByTagName('description')->item(0)->nodeValue,
		            'date' => get_region_halland_page_rss_link_fix_date($myNode->getElementsByTagName('date')->item(0)->nodeValue),
		        );

		        // Pusha variabler tillbaka till Tmp-arrayen 
		        array_push($myFeeds, $myItem);
		    	
		        // Iterera räknaren
		    	$myAntal++;

		    	// Om antal är valt och antal är uppnått, bryt foreach
		    	if ($myRssAntal <> 0) {
			    	if ($myAntal == $myRssAntal) {
			    		break;
			    	}
		    	}
		    }

		    $myData['title'] = $myRssTitle;
		    $myData['rss'] = $myFeeds;
		    $myData['has_content'] = 1;

		} else {

		    $myData['has_content'] = 0;

		}

	    // Returnera data
		return $myData;
		
	}

	function get_region_halland_page_rss_link_fix_date($date) {
        return str_replace("T", " ", substr($date,0,16));
    }


	// Metod som anropas när pluginen aktiveras
	function region_halland_acf_page_rss_link_activate() {
	}

	// Metod som anropas när pluginen avaktiveras
	function region_halland_acf_page_rss_link_deactivate() {
		// Ingenting just nu...
	}
	
	// Vilken metod som ska anropas när pluginen aktiveras
	register_activation_hook( __FILE__, 'region_halland_acf_page_rss_link_activate');

	// Vilken metod som ska anropas när pluginen avaktiveras
	register_deactivation_hook( __FILE__, 'region_halland_acf_page_rss_link_deactivate');

?>