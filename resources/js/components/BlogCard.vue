<template>
    <v-card class="mx-auto" max-width="400">
        <v-img class="white--text align-end" height="200px"
            :src="blog.image_url ? blog.image_url : 'https://placehold.co/600x400?text=No+Image'">
            <v-card-title>{{ blog.title }}</v-card-title>
        </v-img>

        <v-card-text class="text--primary" style="height: 250px;">
            <p>Date: {{ blog.published_at }}</p>
            <p>By: {{ blog.author }}</p>
            <p>{{ truncatedBody }}</p>
        </v-card-text>
        <v-card-actions>
            <v-btn v-if="authenticated" :color="likedColor" text @click="likeBlog">
                Like {{ likesCount > 0 ? `(${likesCount})` : '' }}
            </v-btn>

            <v-btn color="primary" text :to="`/blogs/${blog.id}`">
                View
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    props: {
        blog: { type: Object, default: null }
    },
    data: () => ({
        likesCount: 0,
        liked: false
    }),
    computed: {
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        likedColor() {
            return this.liked ? 'green' : 'primary'
        },
        truncatedBody() {
            if (this.blog.body.length > 200) {
                return this.blog.body.substring(0, 200) + '...'
            }
            return this.blog.body
        }
    },
    mounted() {
        this.likesCount = this.blog.likes_count
        this.liked = this.blog.liked_by_me
    },
    methods: {
        likeBlog() {
            this.loading = false
            this.$http
                .post(`/api/blogs/${this.blog.id}/like`)
                .then(({ data }) => {
                    this.likesCount = data.data.likes_count
                    this.liked = data.data.liked_by_me
                })
                .catch(error => {
                    console.log(error)
                    this.loading = false
                })
        }
    }
}
</script>
