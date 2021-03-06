// 'use strict';

require('jquery');
window.$ = jQuery;
require('./insertParam');
require('./getCookie');
require('./vendor/colorpicker/minicolors');
require('./preview-get-dependancies');
require('./preview-send-values');

jQuery(document).ready(function($) {

  require('./update-last-group-and-tab');
  require('./dropdown-nav');
  require('./dropdown-subnav-links');
  require('./overlay');

  require('./form-saved');
  require('./expand-textarea');

  require('./sidebar-diagram');
  require('./sidebar-values');
  // preview field values
  require('./minicolors');
  require('./hiddenfield-change');
  require('./preview-textarea-update');
  require('./preview-general');
  require('./preview-ajax');
  require('./preview-custom-code');
  require('./preview-sidebar');

  // preview behavior
  require('./preview-size');
  require('./preview-affix');

  require('./sortable');
  require('./toggle-fields');

  require('./notification-auto-dismiss');
  require('./removeNag');

  require('./media-library');

  require('./addSuffix');


	require('./extendFields'); // might be dead


});
