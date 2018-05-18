
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.Popper = require('popper.js').default;
window.Vue = require('vue');

require('./bootstrap');
let lib = require('./lib');
let taskId;
let localValue;
let debounce = lib.debounce;

$(function(){
	//получить подробности задачи
	$('.task_item').click(function() {
		taskId = $(this).data('id');
		localValue = localStorage[taskId];
		lib.taskItem(taskId, localValue);
	});
});

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
		},
		taskItem(id){
			taskId = id;
			localValue = localStorage[taskId];
			lib.taskItem(taskId, localValue);
		}
	}
});
