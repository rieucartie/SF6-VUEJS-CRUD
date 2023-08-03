import axios from 'axios';

const state = () => ({
    products: [],

    productsBySearch: [],

    ProductDetail: [],

    isLoading: false,

    isCreating: false,
    createdData: null,

     isUpdating: false,
     updatedData: null,


    isDeleting: false,
    deletedData: null,

    search: null

})

const getters = {
    product: state => state.products,

    getProductDetail: state => {
        return state.ProductDetail;
    },
    search: state => state.search,

    getProducts(state) {
        return state.products;
    },

    getProductsBySearch(state) {
        return state.productsBySearch;
    },

    isLoading: state => state.isLoading,

    isCreating: state => state.isCreating,
    createdData: state => state.createdData,

     isUpdating: state => state.isUpdating,
     updatedData: state => state.updatedData,

    isDeleting: state => state.isDeleting,
    deletedData: state => state.deletedData

};

const actions = {

    async fetchDetailProduct({ commit }, id) {
        try {
            const response = await axios.get(`/products/edit/${id}`);
            commit('setProductDetail', JSON.parse(response.data));
            return JSON.parse(response.data);
        } catch (error) {
            console.error('Error fetching product detail:', error);
            throw error;
        }
    },
    async fetchAllProducts({commit, state}, query = null) {

        let search = null;

        if(query !== null){
            search = query?.search || '';
        }
        let url ="/products"

        if (search != null) {
            url = `/products/view/search?search=${search}`
        }

        return new Promise((resolve, reject) => {
            axios.get(url)
                .then((response) => {
                    if (search === null){
                        commit('setProducts', JSON.parse(response.data));
                        resolve(state.products);
                    }

                    else if (search != null) {
                        commit('setProductsBySearch', response.data);
                        resolve(state.productsBySearch);
                    }
                });
        });
    },


    async storeProduct({ commit }, product) {

        commit('setProductIsCreating', true);

        await axios.post(`products/create`, product)

            .then(res => {
                commit('saveNewProducts', res.data.data);
                commit('setProductIsCreating', false);
            })
            .catch(err => {
                console.log('error', err);
                commit('setProductIsCreating', false);
            });
    },


    async updateProduct({ commit }, product) {
        commit('setProductIsUpdating', true);
        commit('setProductIsUpdating', true);
        await axios.put(`products/update/${product.id}`, product)
            .then(res => {
                commit('saveUpdatedProduct', res.data.data);
                commit('setProductIsUpdating', false);
            }).catch(err => {
                console.log('error', err);
                commit('setProductIsUpdating', false);
            });
    },

    async deleteProduct({ commit }, id) {
        commit("setProductIsDeleting", true);
        try {
            await axios.delete(`/products/delete/${id}`);
            commit("setDeleteProduct", id);
            commit("setProductIsDeleting", false);

        } catch (error) {
            console.log("error", error);
            commit("setProductIsDeleting", false);
        }
    },

    updateProductInput({ commit }, e) {
        commit('setProductDetailInput', e);
    },



}

const mutations = {

    saveNewProducts: (state, product) => {
        state.createdData = product;
    },

    setProductIsCreating(state, isCreating) {
        state.isCreating = isCreating
    },

    setProducts: (state, products) => {
        state.products = products
    },

    setProductsBySearch: (state, products) => {
        const jsonObject = JSON.parse(products);
        state.productsBySearch = jsonObject

    },

    setProductIsLoading(state, isLoading) {
        state.isLoading = isLoading
    },

    setProductDetail(state, productDetail) {
        state.ProductDetail = productDetail;
    },

    setProductDetailInput: (state, e) => {
        let product = state.products;
        product[e.target.name] = e.target.value;
        state.product = product
    },

   saveUpdatedProduct: (state, product) => {
        state.products.unshift(product)
        state.updatedData = product;
    },

     setProductIsUpdating(state, isUpdating) {
        state.isUpdating = isUpdating
    },

    setDeleteProduct: (state, id) => {
        state.products.filter(x => x.id !== id);
    },

    setProductIsDeleting(state, isDeleting) {
        state.isDeleting = isDeleting
    },

}

export default {
    // namespaced: true,
    state,
    getters,
    actions,
    mutations
}
