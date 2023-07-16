<template>
    <div class="mx-auto" style="max-width: 800px;">
        <v-breadcrumbs :items="breadcrumbItems"></v-breadcrumbs>
        <v-card rounded="lg" class="mx-auto" max-width="800">
            <v-img class="white--text align-end" height="600px"
                :src="blog.image_url ? blog.image_url : 'https://placehold.co/600x400?text=No+Image'">
                <v-card-title>{{ blog.title }}</v-card-title>
            </v-img>

            <v-card-text class="text--primary" style="height: 250px;">
                <p>Date: {{ blog.published_at }}</p>
                <p>By: {{ blog.author }}</p>
                <p>{{ blog.body }}</p>
            </v-card-text>
            <v-card-actions>
                <v-btn v-if="authenticated" :color="likedColor" text @click="likeBlog">
                    Like {{ blog.likes_count > 0 ? `(${blog.likes_count})` : '' }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    layout: 'default',

    props: {
        blogId: {
            type: String,
            default: 0
        }
    },

    metaInfo() {
        return { title: 'Blog' }
    },

    data: () => ({
        title: window.config.appName,
        breadcrumbItems: [
            {
                text: 'Home',
                disabled: false,
                href: '/',
            }
        ],
        blog: {},
        loading: true
    }),
    computed: {
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        likedColor() {
            return this.blog.liked_by_me ? 'green' : 'primary'
        }
    },
    mounted() {
        this.loadData()
    },
    methods: {
        async loadData() {
            this.loading = false
            this.$http
                .get(`/api/home/blogs/${this.blogId}`)
                .then(({ data }) => {
                    this.blog = data.data
                    this.breadcrumbItems.push({
                        text: this.blog.title,
                        disabled: true,
                        href: ''
                    })
                    this.loading = false
                })
                .catch(error => {
                    console.log(error)
                    if(error.response.status === 404){
                        this.$router.push('/errors/404');
                    }
                    this.loading = false
                })
        },
        likeBlog() {
            this.loading = false
            this.$http
                .post(`/api/blogs/${this.blog.id}/like`)
                .then(({ data }) => {
                    this.blog = data.data
                })
                .catch(error => {
                    console.log(error)
                    this.loading = false
                })
        }
    }
}
</script>
