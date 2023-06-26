<template>
    <div class="p-3">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <div>
                    <span class="card-title h6 fw-bold">Products</span>
                </div>
                <div>
                    <a href="/products/create" class="btn btn-primary shadow">Add New Product</a>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="container-fluid my-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." v-model="search"
                                    @input="debouncedSearch">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" v-model="category" multiple>
                                <option value="">All Categories</option>
                                <option v-for="(c, index) in categories" :value="c.id" :key="index">{{ c.name }}</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-striped border">
                        <thead>
                            <tr>
                                <th class="text-center">Images</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in filteredProducts" :key="product.id" class="align-middle">
                                <td class="text-center">
                                    <div class="avatar-group">
                                        <div v-for="image in product.images" :key="image.id" class="avatar">
                                            <img :src="`/storage/${image.path}`" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ product.name }}</td>
                                <td>
                                    <span v-html="product.description"></span>
                                </td>
                                <td>
                                    <div v-for="category in product.categories" :key="category.id">{{ category.name }},
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-success" :href="`/products/${product.id}/edit`">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" v-if="pagination.prev">
                                <button class="page-link" @click="goToPage(pagination.prev)">
                                    Prev
                                </button>
                            </li>
                            <li class="page-item" v-for="pageNumber in pagination.pages" :key="pageNumber">
                                <button class="page-link" @click="goToPage(pageNumber)"
                                    :class="{ active: pageNumber === pagination.current }">
                                    {{ pageNumber }}
                                </button>
                            </li>
                            <li class="page-item" v-if="pagination.next">
                                <button class="page-link" @click="goToPage(pagination.next)">
                                    Next
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="center-spinner" v-if="loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';
import { ref, reactive, computed, watch } from 'vue';
import { debounce } from 'lodash';

export default {
    setup() {
        const products = ref([]);
        const categories = ref([]);
        const search = ref('');
        const category = ref([]);
        const page = ref(1);
        const loading = ref(false);
        const pagination = reactive({
            total: 0,
            perPage: 5,
            totalPages: 0,
            current: 1,
            prev: null,
            next: null,
            start: 0,
            end: 0,
            pages: [],
        });

        const fetchCategories = async () => {
            const response = await axios.get(`/api/v1/categories`);
            categories.value = response.data;
        };

        fetchCategories();

        const loadProducts = async () => {
            try {
                loading.value = true;
                const response = await axios.get('/api/v1/products', {
                    params: {
                        page: page.value,
                        search: search.value,
                        category: category.value,
                    },
                });
                products.value = response.data.data;
                pagination.total = response.data.total;
                pagination.totalPages = response.data.last_page;
                pagination.current = response.data.current_page;
                pagination.prev = response.data.prev_page_url ? pagination.current - 1 : null;
                pagination.next = response.data.next_page_url ? pagination.current + 1 : null;
                pagination.start = (pagination.current - 1) * pagination.perPage;
                pagination.end = Math.min(pagination.start + pagination.perPage, pagination.total);
                pagination.pages = Array.from({ length: pagination.totalPages }, (_, i) => i + 1);
                loading.value = false;
            } catch (error) {
                console.error(error);
            }
        };

        const debouncedSearch = debounce(() => {
            page.value = 1;
            loadProducts();
        }, 500);

        const filteredProducts = computed(() => {
            return products.value;
        });

        const goToPage = (pageNumber) => {
            page.value = pageNumber;
            loadProducts();
        };

        watch([category], () => {
            page.value = 1;
            loadProducts();
        });

        watch(search, () => {
            debouncedSearch();
        });

        loadProducts();

        return {
            products,
            categories,
            search,
            category,
            loading,
            filteredProducts,
            pagination,
            goToPage,
        };
    },
};
</script>
