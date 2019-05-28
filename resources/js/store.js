import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
		products: {}
    },
    mutations: {
		GET_PRODUCTS(state, products){
			state.products = products
		},
    },
    actions: {
		
    }
})