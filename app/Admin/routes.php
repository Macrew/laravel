<?php

Route::get('', [
	'as' => 'admin.home',
	function ()
	{
		$content = 'Define your dashboard here.';
		return Admin::view($content, 'Dashboard');
	}
]);


Route::get('builder/create', 'BuilderController@create_builder');
Route::post('builder/add', 'BuilderController@add_builder');
Route::get('builders', 'BuilderController@get_builders');
Route::get('builder/edit/{builder_id}', 'BuilderController@edit_builder');
Route::post('builder/update/{builder_id}', 'BuilderController@update_builder');
Route::get('builder/delete/{builder_id}', 'BuilderController@delete_builder');
Route::get('builder/featured/{builder_id}', 'BuilderController@featured_builder');
Route::post('builder/check_username', 'BuilderController@check_username');


Route::get('user/create', 'BuilderController@create_user');
Route::post('user/add', 'BuilderController@add_user');
Route::get('users', 'BuilderController@get_users');
Route::get('user/edit/{user_id}', 'BuilderController@edit_user');
Route::post('user/update/{user_id}', 'BuilderController@update_user');
Route::get('user/delete/{user_id}', 'BuilderController@delete_user');


Route::get('state/create', 'StateController@create_state');
Route::post('state/add', 'StateController@add_state');
Route::get('states', 'StateController@get_states');
Route::get('state/edit/{state_id}', 'StateController@edit_state');
Route::post('state/update/{state_id}', 'StateController@update_state');
Route::get('state/delete/{state_id}', 'StateController@delete_state');
Route::get('state/visibilty', 'StateController@get_all_states');
Route::get('state/change_visibilty/{state_name}/{status}', 'StateController@change_visibilty');

Route::get('inclusion/create', 'InclusionController@create_inclusion');
Route::post('inclusion/add', 'InclusionController@add_inclusion');
Route::get('inclusions', 'InclusionController@get_inclusions');
Route::get('inclusion/edit/{inc_id}', 'InclusionController@edit_inclusion');
Route::post('inclusion/update/{inc_id}', 'InclusionController@update_inclusion');
Route::get('inclusion/delete/{inc_id}', 'InclusionController@delete_inclusion');
Route::get('inclusion/tree/{catid}', 'InclusionController@category_tree1');
Route::post('inclusion/filter/update', 'InclusionController@update_filter_inclusion');


Route::get('property/create', 'PropertyController@create_property');
Route::post('property/add', 'PropertyController@add_property');
Route::get('properties', 'PropertyController@get_properties');
Route::get('properties/{prop_id}/activate/{activate}', 'PropertyController@activate_properties');
Route::get('property/edit/{prop_id}', 'PropertyController@edit_property');
Route::get('property/view/{prop_id}', 'PropertyController@view_property');
Route::post('property/update/{prop_id}', 'PropertyController@update_property');
Route::get('property/delete/{prop_id}', 'PropertyController@delete_property');
Route::get('property/gallery', 'PropertyController@get_galleries');
Route::get('property/gallery/create', 'PropertyController@create_gallery');
Route::get('property/gallery/add', 'PropertyController@add_gallery');
Route::post('property/gallery/ajax_builder_properties', 'PropertyController@ajax_get_builder_properties');
Route::post('property/gallery/ajax_store_gallery_images', array('as'=>'upload', 'before'=>'auth','uses'=>'PropertyController@ajax_save_property_images'));
Route::post('property/gallery/ajax_set_property', 'PropertyController@ajax_set_propertyid');
Route::get('property/gallery/edit/{prop_id}', 'PropertyController@edit_gallery');
Route::get('property/gallery/delete/{prop_id}', 'PropertyController@delete_gallery_image');
Route::post('property/gallery/ajax_update_gallery_images', array('as'=>'upload', 'before'=>'auth','uses'=>'PropertyController@ajax_update_gallery_images'));
Route::get('property/gallery/add_gallery_images/{propid}', 'PropertyController@add_more_images');
Route::post('property/inclusion/update/{prop_id}/{builder_id}', 'PropertyController@update_inclusion');
Route::post('property/remove-inclusion/{prop_id}/{builder_id}', 'PropertyController@remove_inclusion');
Route::post('property/inclusion/add/{builder_id}', 'PropertyController@add_inclusion');
Route::post('property/gallery/ajax_update_floor_images', array('as'=>'upload', 'before'=>'auth','uses'=>'PropertyController@ajax_update_floor_images')); 
Route::get('property/floorplans/delete/{prop_id}', 'PropertyController@delete_floor_plans_img');
Route::get('property/featured/{prop_id}', 'PropertyController@featured_property');
Route::post('property/display-home/add/{prop_id}', 'PropertyController@save_display_home');
Route::get('property/display-home/delete/{prop_id}', 'PropertyController@delete_display_home');
Route::get('property/display-home/edit/{prop_id}/{builder_id}', 'PropertyController@edit_display_home');
Route::post('property/display-home/update/{prop_id}', 'PropertyController@update_display_home');
Route::get('property/display-home/create/{builder_id}', 'PropertyController@create_display_home');
Route::get('property/sort_featured', 'PropertyController@sort_properties');
Route::post('property/update_sort_properties', 'PropertyController@update_sort_properties');
Route::get('property/update_long', 'PropertyController@update_long');
Route::get('land/update_long', 'LandEstateController@update_long');

Route::get('property/sort_gallery/{id}', 'PropertyController@sort_gallery');
Route::post('property/update_sort_gallery', 'PropertyController@update_sort_gallery');
Route::get('property/edit-property-inclusion/{prop_id}/{builder_id}', 'PropertyController@edit_property_inclusion');
Route::get('property/add-property-inclusion/{builder_id}', 'PropertyController@add_property_inclusion');
Route::post('properties', 'PropertyController@change_order');


Route::get('house-and-lands', 'PropertyController@get_house_lands');
Route::get('house-and-land/create', 'PropertyController@create_house_land');
Route::get('house-and-land/{prop_id}/activate/{activate}', 'PropertyController@activate_house_lands');
Route::get('house-and-land/edit/{prop_id}', 'PropertyController@edit_house_land');
Route::get('house-and-land/view/{prop_id}', 'PropertyController@view_house_land');
Route::post('house-and-land/update/{prop_id}', 'PropertyController@update_house_land');
Route::get('house-and-land/delete/{prop_id}', 'PropertyController@delete_house_land');
Route::post('house-and-land/add', 'PropertyController@add_house_land');
Route::get('house-and-lands/gallery', 'PropertyController@get_house_land_galleries');
Route::get('house-and-land/featured/{prop_id}', 'PropertyController@featured_house_land');
Route::get('house-and-land/sort_featured', 'PropertyController@sort_house_land');
Route::get('house-and-land/gallery/edit/{prop_id}', 'PropertyController@edit_house_land_gallery');
Route::get('house-and-land/gallery/add_gallery_images/{propid}', 'PropertyController@add_more_house_land_images');
Route::get('house-and-land/sort_gallery/{id}', 'PropertyController@sort_house_land_gallery');
Route::get('house-and-land/gallery/create', 'PropertyController@create_house_land_gallery');
Route::post('house-and-land/gallery/ajax_builder_properties', 'PropertyController@ajax_get_builder_house_land');

Route::get('landestate/create', 'LandEstateController@create_landestate');
Route::post('landestate/add', 'LandEstateController@add_landestate');
Route::get('landestates', 'LandEstateController@get_landestates');
Route::get('landestate/edit/{landestate_id}', 'LandEstateController@edit_landestate');
Route::post('landestate/update/{landestate_id}', 'LandEstateController@update_landestate');
Route::get('landestate/delete/{landestate_id}', 'LandEstateController@delete_landestate');
Route::post('land/gallery/ajax_store_land_images', 'LandEstateController@ajax_store_land_images');

Route::post('land/display-land/add/{landestate_id}', 'LandEstateController@save_display_land');
Route::get('land/display-land/delete/{landestate_id}', 'LandEstateController@delete_display_land');
Route::get('land/display-land/edit/{landestate_id}', 'LandEstateController@edit_display_land');
Route::post('land/display-land/update/{landestate_id}', 'LandEstateController@update_display_land');
Route::get('land/images/delete/{landestate_id}', 'LandEstateController@delete_land_images');
Route::get('land/import_gallery_images', 'LandEstateController@import_gallery_images');
Route::get('landestate/manage-display-land-location', 'LandEstateController@manage_display_land_location');
Route::post('land/change-land-state-search', 'LandEstateController@change_state_new_ajax');
Route::post('lands/ajax_filter_map_lands', 'LandEstateController@ajax_filter_map_lands');
Route::post('lands/update_land_location', 'LandEstateController@update_land_location');

Route::get('broker/create', 'BrokerController@create_broker');
Route::post('broker/add', 'BrokerController@add_broker');
Route::get('brokers', 'BrokerController@get_brokers');
Route::get('broker/edit/{broker_id}', 'BrokerController@edit_broker');
Route::post('broker/update/{broker_id}', 'BrokerController@update_broker');
Route::get('broker/delete/{broker_id}', 'BrokerController@delete_broker');

Route::get('category_partner', 'CategoryController@get_partner');
Route::get('category_partner/create_partner', 'CategoryController@create_partner');
Route::post('partner/add', 'CategoryController@add_parnter');
Route::get('partner/edit/{partner_id}', 'CategoryController@edit_parnter');
Route::post('partner/update/{partner_id}', 'CategoryController@update_parnter');
Route::get('partner/delete/{partner_id}', 'CategoryController@delete_partner');

Route::get('page/create', 'ContentController@create_page');
Route::post('page/add', 'ContentController@add_page');
Route::get('pages', 'ContentController@get_pages');
Route::get('page/edit/{page_id}', 'ContentController@edit_page');
Route::post('page/update/{page_id}', 'ContentController@update_page');
Route::get('page/delete/{page_id}', 'ContentController@delete_page');

Route::get('blog/create', 'ContentController@create_blog');
Route::post('blog/add', 'ContentController@add_blog');
Route::get('blogs', 'ContentController@get_blogs');
Route::get('blog/edit/{page_id}', 'ContentController@edit_blog');
Route::post('blog/update/{page_id}', 'ContentController@update_blog');
Route::get('blog/delete/{page_id}', 'ContentController@delete_blog');


Route::get('category/create', 'ContentController@create_category');
Route::post('category/add', 'ContentController@add_category');
Route::get('categories', 'ContentController@get_categories');
Route::get('category/edit/{cat_id}', 'ContentController@edit_category');
Route::post('category/update/{cat_id}', 'ContentController@update_category');
Route::get('category/delete/{cat_id}', 'ContentController@delete_category');


//Routes for testimonials
Route::get('testimonials', 'ContentController@testimonials');
Route::get('testimonials/create', 'ContentController@create_testimonials');
Route::post('testimonials/create', 'ContentController@posttestimonials');
Route::get('testimonials/edit/{id}', 'ContentController@edit_testimonials');
Route::post('testimonials/edit/{id}', 'ContentController@edit_post_testimonials');
Route::get('testimonials/delete/{id}', 'ContentController@delete_testimonials');
Route::get('testimonials/featured/{id}/{featured_var}', 'ContentController@featured_testimonial');


Route::get('ads', 'ContentController@get_ads');
Route::get('ads/create', 'ContentController@create_ads');
Route::post('ads/add', 'ContentController@save_ads');
Route::get('ads/edit/{id}', 'ContentController@edit_ads');
Route::post('ads/update/{id}', 'ContentController@update_ads');
Route::get('ads/delete/{id}', 'ContentController@delete_ads');
Route::get('ads/change_ads_status/{ad_id}/{status}', 'ContentController@change_ads_status');


/* Route::get('land/create', 'LandEstateController@create_land');
Route::post('land/add', 'LandEstateController@add_land');
Route::get('landestate', 'LandEstateController@get_land');
Route::get('land/edit/{landestate_id}', 'LandEstateController@edit_land');
Route::post('land/update/{landestate_id}', 'LandEstateController@update_land');
Route::get('land/delete/{landestate_id}', 'LandEstateController@delete_land');
 */

