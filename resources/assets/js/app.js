
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.Popper = require('popper.js').default;
window.Vue = require('vue');

require('./bootstrap');
require('./taskItem');

Vue.directive('debounce', (el, binding) => {
	if (binding.value !== binding.oldValue) {
		// window.debounce is our global function what we defined at the very top!
		el.oninput = debounce(ev => {
			el.dispatchEvent(new Event('change'));
		}, parseInt(binding.value) || 300);
	}
});

//поиск
new Vue({
	el: '#app',
	
  data() {
    return {
      keywords: null,
      results: []
    };
  },

  watch: {
    keywords(after, before) {
      this.fetch();
    }
  },

  methods: {
    fetch() {
      axios.post('/searchTask', {_token: $('meta[name="csrf-token"]').attr('content'), str: this.keywords})
        .then(response => this.results = response.data.data)
        .catch(error => {});
    },
    highlight(text) {
			return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
		}
  }
});

function debounce(fn, delay = 300) {
	var timeoutID = null;

    return function () {
		clearTimeout(timeoutID);

        var args = arguments;
        var that = this;

        timeoutID = setTimeout(function () {
        	fn.apply(that, args);
        }, delay);
    }
};