// Create empty jQuery object which is interpreted in axZm/jquery.axZm.loader.js
var ajaxZoom = {};

// Define callbacks, for complete list check the docs
// http://www.ajax-zoom.com/index.php?cid=docs#API_CALLBACKS
ajaxZoom.opt = {
	onBeforeStart: function(){
		// Some of the options can be set directly as js var in this callback
		jQuery.axZm.spinReverse = true;
	}
};

// Define the path to the axZm folder, adjust the path if needed!
ajaxZoom.path = "../axZm/";

// Define your custom parameter query string
// example=17 has many presets for 360 images*
// 3dDir - best of all absolute path to the folder with 360/3D images
// *By defining the query string parameter in ajaxZoom.parameter example=17
// some default settings from /axZm/zoomConfig.inc.php are overridden in
// /axZm/zoomConfigCustom.inc.php after elseif ($_GET['example'] == 17){.
// So if changes in /axZm/zoomConfig.inc.php have no effect -
// look for the same options /axZm/zoomConfigCustom.inc.php;
ajaxZoom.parameter = "example=17&3dDir=/pic/zoom3d/Uvex_Occhiali";

// The ID of the element (placeholder) where AJAX-ZOOM has to be inserted into
ajaxZoom.divID = "AZplayerParentContainer";

// Load AJAX-ZOOM
jQuery(document).ready(function(){
	jQuery.fn.axZm.load({
		opt: ajaxZoom.opt,
		path: ajaxZoom.path,
		parameter: ajaxZoom.parameter,
		divID: ajaxZoom.divID
	});
});