<?php

Admin::menu()->url('/')->label('Dashboard')->icon('fa-dashboard');
/* Admin::menu('App\User')->icon('fa-user'); */
Admin::menu()->url('users')->label('Manage Users')->icon('fa-user');
Admin::menu()->url('builders')->label('Manage Builders')->icon('fa-user');
Admin::menu()->url('landestates')->label('Manage Land Estates')->icon('fa-user');
Admin::menu()->url('brokers')->label('Manage Mortgage Brokers')->icon('fa-user');
Admin::menu()->url('category_partner')->label('Manage Category Partner')->icon('fa-user');
Admin::menu()->url('states')->label('Manage States')->icon('fa fa-location-arrow');
Admin::menu()->url('inclusions')->label('Manage Inclusions')->icon('fa-chevron-right');
Admin::menu()->label('Manage Properties')->icon('fa-chevron-right')->items(function ()
{
   Admin::menu()->url('properties')->label('Properties')->icon('fa fa-angle-double-right');
   Admin::menu()->url('property/gallery')->label('Property Photo Gallery')->icon('fa fa-angle-double-right');
   
});
Admin::menu()->label('Manage Content')->icon('fa-chevron-right')->items(function ()
{
   Admin::menu()->url('pages')->label('Manage Pages')->icon('fa fa-angle-double-right');
  Admin::menu()->label('Manage Blogs')->icon('fa-chevron-right')->items(function ()
{
   Admin::menu()->url('blogs')->label('Blogs')->icon('fa fa-angle-double-right');
   Admin::menu()->url('categories')->label('Categories')->icon('fa fa-angle-double-right');
   
});
   Admin::menu()->url('testimonials')->label('Manage Testimonials')->icon('fa-chevron-right');
   Admin::menu()->url('ads')->label('Manage Ads')->icon('fa-chevron-right');
});
