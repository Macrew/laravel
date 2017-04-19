<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'Home@index');
Route::get('/js/responsiveImg.js.php', function()
{
    include base_path().'/assets/js/responsiveImg.js.php';
});
//Route for login page
Route::get('/login', 'Home@login');
Route::post('/login', 'Home@login_user');

//Route for builder login
Route::get('/builderlogin', 'Home@builderlogin');
Route::post('/builderlogin', 'Home@builder_login');

//Routes for register
Route::get('/register', 'Home@register');
Route::post('/register', 'Home@register_user');

//Route for logout
Route::get('/logout', 'Home@logout');

//Route for reset password
Route::get('forgotpassword', 'Home@forgotpassword');
Route::post('forgotpassword', 'Home@forgotpasswordpost');
Route::get('resetPassword/{token}', ['as' => 'resetPassword', function($token)
{
   return View::make('resetPassword')->with('token', $token); 
}]);
Route::get('password/reset/{token}', 'Home@password_reset');
Route::post('password/reset/{token}', 'Home@savereset_password');

//Route for Builder managment
Route::group(['middleware' => 'App\Http\Middleware\BuilderMiddleware','role:Builer'], function(){
	
Route::get('propertymanagement', 'builderController@propertymanagement');
Route::get('propertymanagement/addproperty', 'builderController@addproperty');
Route::post('propertymanagement/addproperty', 'builderController@addpropertypost');

Route::get('propertymanagement/editproperty/{id}', 'builderController@editproperty');
Route::post('propertymanagement/editproperty/{id}', 'builderController@editpropertypost');
Route::get('propertymanagement/viewproperty/{id}', 'builderController@viewproperty');
Route::post('propertymanagement/propertyinclusions/{id}', 'builderController@propertyinclusions');

//Route for delete property
Route::get('propertymanagement/delete_property/{id}', 'builderController@delete_property');

//Route for uploading images
Route::post('propertymanagement/gallery_images/{id}', 'builderController@gallery_images');
Route::get('propertymanagement/remove_galleryimg/{id}', 'builderController@remove_galleryimg');


Route::get('propertymanagement/remove_floorimg/{id}', 'builderController@remove_floorimg');
Route::post('propertymanagement/floor_images/{id}', 'builderController@floor_images');


Route::get('builder/house-and-land', 'builderController@get_house_lands');
Route::get('builder/house-and-land/add', 'builderController@add_house_land');
Route::post('builder/house-and-land/save', 'builderController@save_house_land');
Route::get('builder/house-and-land/edit/{id}', 'builderController@edit_house_land');
Route::post('builder/house-and-land/update/{id}', 'builderController@update_house_land');
Route::get('builder/house-and-land/view/{id}', 'builderController@view_house_land');
Route::get('builder/house-and-land/delete/{id}', 'builderController@delete_house_land');

//Route for enquiry management
Route::get('enquirymanagement', 'builderController@enquirymanagement');
Route::get('enquirymanagement/delete_enquery/{id}', 'builderController@delete_enquery');


//Routes for Add Management
/* Route::get('addmanagement', 'addController@index');
Route::post('addmanagement', 'addController@index');
Route::get('addmanagement/createadd', 'addController@createadd');
Route::post('addmanagement/createadd', 'addController@postadd');
Route::get('addmanagement/editadd/{id}', 'addController@editadd');
Route::post('addmanagement/editadd/{id}', 'addController@editaddpost');
Route::get('addmanagement/deleteadd/{id}', 'addController@deleteadd'); */


});
//Route for download pdf file
Route::get('propertymanagement/getDownloadfile/{filepath}', 'builderController@getDownloadfile');

//Routes for our builder section
Route::get('ourbuilders', 'builderController@ourbuilders');
Route::get('ourbuilders/{state}', 'builderController@our_builders');
Route::get('builder-detail/{id}', 'builderController@builderdetail');
Route::post('builder-detail/{id}', 'builderController@contactbuilder');

//Route for property listing

Route::get('propertydetail/{id}', 'PropertyController@propertydetail');
Route::post('propertydetail/{id}', 'PropertyController@propertydetailmail');

Route::get('properties', 'PropertyController@index');
Route::get('change-state/{state}', 'PropertyController@change_state');
Route::get('change-state-search/', 'PropertyController@change_state_ajax');
Route::post('land/change-land-state-search', 'PropertyController@change_state_new_ajax');
Route::post('properties/ajax_filter_properties', 'PropertyController@ajax_filter_properties');
Route::post('properties/ajax_filter_count_properties', 'PropertyController@ajax_filter_count_properties');
Route::get('property/search-property', 'PropertyController@search_property');
Route::get('property/get_parent_filter_inc', 'PropertyController@get_parent_filter_inc');
Route::post('property/save_property', 'PropertyController@save_property');
Route::post('property/count_save_property', 'PropertyController@count_save_property');
Route::get('property/contact', 'PropertyController@contact_builder');
Route::post('property/enquire_builder/{prop_id}', 'PropertyController@enquire_builder');
Route::get('property/messages', 'PropertyController@message_notify');
Route::get('property/remove', 'PropertyController@delete_property');
Route::post('property/delete_ajax_property', 'PropertyController@delete_ajax_property');
Route::get('saved-property/delete/{prop_id}', 'PropertyController@delete_saved_property');
Route::get('properties/display-villages/{prop_id}', 'PropertyController@display_villages');
Route::post('property/book_appointment_html', 'PropertyController@book_appointment_html');
Route::post('property/get_time_dropdown', 'PropertyController@get_time_dropdown');
Route::post('property/send_appointment_detail', 'PropertyController@send_appointment_detail');
Route::post('property/load_enquire_form', 'PropertyController@load_enquire_form');
Route::post('property/save_property_new', 'PropertyController@save_property_new');
Route::get('property/update_display_homes', 'PropertyController@update_display_homes');
Route::get('property/update_inclusion', 'PropertyController@update_inclusion');
Route::post('builder/change-builder-state', 'PropertyController@change_builder_state');
Route::post('property/load_rating_form', 'PropertyController@load_rating_form');
Route::post('property/load_floor_plan', 'PropertyController@load_floor_plan');
Route::post('property/send_feedback', 'PropertyController@send_feedback');
Route::post('property/send_request_call_back', 'PropertyController@send_request_call_back');

Route::get('house-and-lands', 'PropertyController@house_lands');
Route::post('properties/ajax_filter_house_land', 'PropertyController@ajax_filter_house_land');
Route::post('properties/ajax_filter_count_house_land', 'PropertyController@ajax_filter_count_house_land');
Route::post('property/load_property_quick_look', 'PropertyController@load_property_quick_look');


Route::get('land-estates', 'LandEstateController@index');
Route::post('land/enquire_land', 'LandEstateController@enquire_land');
Route::post('land/send_email_land', 'LandEstateController@send_email_land');
Route::get('land/view/{land_id}', 'LandEstateController@view_land');
Route::post('land/enquire/{land_id}', 'LandEstateController@enquire_land_mail');
Route::post('lands/ajax_filter_lands', 'LandEstateController@ajax_filter_lands');
Route::post('lands/ajax_filter_count_lands', 'LandEstateController@ajax_filter_count_lands');

Route::get('land/display-land', 'LandEstateController@display_lands');
Route::post('land/book_land_appointment_html', 'LandEstateController@book_land_appointment_html');
Route::post('land/get_land_time_dropdown', 'LandEstateController@get_land_time_dropdown');
Route::post('land/send_land_appointment_detail', 'LandEstateController@send_land_appointment_detail');
Route::post('lands/ajax_filter_map_lands', 'LandEstateController@ajax_filter_map_lands');
Route::post('land/load_master_plan', 'LandEstateController@load_master_plan');

//Route for Compare Property
Route::get('compare', 'CompareController@compare_property');
Route::get('category_tree1/{cat}', 'CompareController@category_tree1');
Route::post('compare/ajax_save_inclusion', 'CompareController@ajax_save_inclusion');
Route::post('property/delete_save_property', 'PropertyController@delete_save_property');
Route::get('favourites/filter', 'CompareController@compare_saved_inclusions');


//Routes for content of site  like aboutus, faq etc.
Route::get('aboutus', 'contentController@aboutus');
Route::get('help', 'contentController@help');
Route::get('builder-enquiry', 'contentController@builder_enquiry');
Route::get('ourstory', 'contentController@ourstory');
Route::get('contactus', 'contentController@contactus');
Route::get('whyicomparebuilders', 'contentController@whyicompare');
Route::get('testimonials', 'contentController@testimonials');
Route::get('terms-and-conditions', 'contentController@termsconditions');
Route::get('privacy-policy', 'contentController@privacypolicy');
Route::get('blog', 'contentController@blog');
Route::get('blog/{slug}', 'contentController@blogbycategory');
Route::get('blog/{slug}/{category}', 'contentController@detailblog');

//route for subscription
Route::get('subscribe', 'SubscriptionController@subscribe');

//route for reset site
Route::get('reset', 'PropertyController@reset_site');

//route for facebook login
Route::get('fbAuth{auth?}','Home@getLoginFacebook');
Route::get('instaAuth','Home@getLoginInstagram');

Route::get('get_user_current_location','Home@get_user_current_location');
	
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('showImage/{w}/{h}/{src}', function ($w , $h , $src) 
{

    $img_path = public_path().'/'.$src;
    $img = Image::make($img_path)->resize($w, $h);

    return $img->response('png');
})->where('src', '[A-Za-z0-9\/\.\-\_]+');