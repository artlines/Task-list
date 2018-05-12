
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Popper = require('popper.js').default;
require('./bootstrap');

window.Vue = require('vue');

$('.task_item').click(function () {
	alert($(this).data('id'));
})