<?php namespace SleepingOwl\Admin\Templates;

use SleepingOwl\Admin\AssetManager\AssetManager;
use SleepingOwl\Admin\Interfaces\TemplateInterface;

class TemplateDefault implements TemplateInterface
{

	/**
	 *
	 */
	function __construct()
	{
		AssetManager::addStyle('admin::default/css/bootstrap.min.css');
		AssetManager::addStyle('admin::default/css/sb-admin-2.css');
		AssetManager::addStyle('admin::default/css/font-awesome.min.css');
		AssetManager::addStyle('admin::default/css/dataTables.bootstrap.css');
		//AssetManager::addStyle('admin::default/css/bootstrap-switch.css');
		AssetManager::addStyle('admin::default/css/custom.css');
		//AssetManager::addStyle('admin::default/css/toggles.css');

		AssetManager::addScript(route('admin.lang'));
		AssetManager::addScript('admin::default/js/jquery-1.11.0.js');
		AssetManager::addScript('admin::default/js/bootstrap.min.js');
		//AssetManager::addScript('admin::default/js/bootstrap-switch.js');
		AssetManager::addScript('admin::default/js/custom.js');
		AssetManager::addScript('admin::default/js/sb-admin-2.js');
		AssetManager::addScript('admin::default/js/metisMenu.min.js');
		AssetManager::addScript('admin::default/js/admin-default.js');
		//AssetManager::addScript('admin::default/js/toggles.min.js');
		
		
		/* jquery ckeditor */
		AssetManager::addScript('admin::default/ckeditor/ckeditor.js');
		/* datatables */
		
		AssetManager::addScript('admin::default/js/datatables/jquery.dataTables.min.js');
		AssetManager::addScript('admin::default/js/datatables/jquery.dataTables_bootstrap.js');
		
		/* Select2 plugin */
		
		AssetManager::addScript('admin::default/select2/dist/js/select2.min.js');
		AssetManager::addStyle('admin::default/select2/dist/css/select2.min.css');
		
		
		/* AssetManager::addScript('admin::default/jquery-fileupload/js/vendor/jquery.ui.widget.js');
		AssetManager::addScript('admin::default/jquery-fileupload/js/jquery.iframe-transport.js');
		AssetManager::addScript('admin::default/jquery-fileupload/js/jquery.fileupload.js');
		AssetManager::addStyle('admin::default/jquery-fileupload/css/jquery.fileupload.css'); */
		
		AssetManager::addScript('admin::default/dropzone/dropzone.js');
		AssetManager::addStyle('admin::default/dropzone/dropzone.css');
		
		
		AssetManager::addScript('admin::default/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js');
		AssetManager::addStyle('admin::default/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css');
		
		AssetManager::addScript('admin::default/timepicker/jquery.timepicker.js');
		AssetManager::addStyle('admin::default/timepicker/jquery.timepicker.css');
		
		AssetManager::addScript('admin::default/datepicker/bootstrap-datepicker.js');
		AssetManager::addStyle('admin::default/datepicker/bootstrap-datepicker.css');
		
		
		
	}

	/**
	 * Get full view name
	 * @param string $view
	 * @return string
	 */
	public function view($view)
	{
		return 'admin::default.' . $view;
	}

}