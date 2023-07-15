<template>
  <div>
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container v-if="authenticated" class="py-0 fill-height admin-container flex justify-space-between" fluid>
        <h3>My CMS</h3>
        <v-btn
          text
          rounded
          large
          to="/"
          type="button"
          class="text-capitalize text-base font-weight-regular px-6"
        >
          <v-icon left>
            mdi-home
          </v-icon>
          Home
        </v-btn>
        <v-btn
          text
          rounded
          large
          :to="{ name: 'blogs' }"
          type="button"
          class="text-capitalize text-base font-weight-regular px-6"
        >
          <v-icon left>
            mdi-post
          </v-icon>
          Blogs
        </v-btn>
        <v-btn color="primary" @click="logout">
          Logout
        </v-btn>
      </v-container>
      <v-container v-else class="py-0 fill-height admin-container flex justify-space-between" fluid>
        <h3>My CMS</h3>

        <div>
          <v-btn color="primary" to="/login">
            Login
          </v-btn>
          <v-btn color="primary" to="/register">
            Register
          </v-btn>
        </div>
      </v-container>
    </v-app-bar>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
</style>
