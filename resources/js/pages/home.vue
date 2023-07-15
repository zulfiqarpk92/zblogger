<template>
    <div>
        <v-row>
            <v-col>
                <v-text-field v-model="search" clearable label="Search Blogs" @keyup.enter="loadData" />
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <div class="text-center">
                    <v-pagination v-model="page" :length="totalPages" />
                </div>
            </v-col>
        </v-row>
        <v-row v-if="totalBlogs > 0">
            <v-col v-for="blog in blogs.data" :key="blog.id" cols="12" sm="6" md="3">
                <blog-card :blog="blog" />
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col>
                No blogs found.
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <div class="text-center">
                    <v-pagination v-model="page" :length="totalPages" />
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BlogCard from '../components/BlogCard.vue'

export default {
    components: {
        BlogCard
    },
    layout: 'default',

    metaInfo() {
        return { title: 'Home' }
    },

    data: () => ({
        title: window.config.appName,
        search: '',
        blogs: [],
        page: 1,
        totalBlogs: 0,
        loading: true
    }),

    computed: {
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        totalPages() {
            return Math.ceil(this.totalBlogs / 4)
        }
    },
    watch: {
        page(newValue) {
            this.loadData()
        }
    },

    mounted() {
        this.loadData()
    },

    methods: {
        async loadData() {
            this.loading = false
            this.$http
                .get(`/api/home/blogs?page=${this.page}&q=${this.search}`)
                .then(({ data }) => {
                    this.blogs = data
                    this.totalBlogs = data.meta.total
                    this.loading = false
                })
                .catch(error => {
                    console.log(error)
                    this.loading = false
                })
        }
    }
}
</script>

<style scoped>
</style>
