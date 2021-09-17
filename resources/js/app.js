/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "chat-component",
    require("./components/ChatComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const scrollToBottom = el => {
    el.scrollTop = el.scrollHeight;
};

const emit = (vnode, name, data) => {
  var handlers = (vnode.data && vnode.data.on) ||
    (vnode.componentOptions && vnode.componentOptions.listeners);

  if (handlers && handlers[name]) {
    handlers[name].fns(data);
  }
}
let newData = false;

const vChatScroll = {
    bind: (el, binding, vnode) => {

        let timeout;
        let scrolled = false;
        let scrolledTop = false;

        el.addEventListener('scroll', e => {

            if (timeout) window.clearTimeout(timeout);
            timeout = window.setTimeout(function() {
                scrolled = el.scrollTop + el.clientHeight + 1 < el.scrollHeight;
                if(el.scrollTop < 10){
                    emit(vnode, 'scroll-top', "123")
                    scrolledTop = true
                }
            }, 200);
        });

        (new MutationObserver(e => {
            let config = binding.value || {};
            let pause = config.always === false && scrolled;
            if (!newData) {
                if(scrolledTop) return el.scrollTop = 10;
            }
            if (pause || e[e.length - 1].addedNodes.length != 1) return;
            scrollToBottom(el);
        })).observe(el, {childList: true, subtree: true});
    },
    update(el, binding){
        newData = binding.value.newData
      },
    inserted: scrollToBottom
};

Vue.directive('chat-scroll', vChatScroll);





import vmodal from "vue-js-modal";
import Multiselect from "vue-multiselect";
import TextareaAutosize from 'vue-textarea-autosize';

Vue.use(TextareaAutosize)
// register globally
Vue.component("multiselect", Multiselect);
Vue.use(vmodal);
Vue.use(require("vue-moment"));
const app = new Vue({
    el: "#app"
});
