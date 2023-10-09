require('select2');
require('select2/dist/js/i18n/zh-TW');
$.fn.select2.defaults.set('language', 'zh-TW');

require('bootstrap-datepicker/js/bootstrap-datepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-TW');
require('admin-lte/plugins/input-mask/jquery.inputmask');
require('admin-lte/plugins/timepicker/bootstrap-timepicker');
require('./jquery-sortable/jquery-sortable.min')

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
  window.$ = window.jQuery = require('jquery');
  require('bootstrap');
  require('admin-lte');
} catch (e) {}