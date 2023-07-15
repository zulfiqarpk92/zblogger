<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card height="100%" width="100%" class="ml-auto py-8 px-6">
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <h2 class="text-2xl font-weight-semibold">
              My CMS
            </h2>
          </router-link>
        </v-card-title>

        <v-form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <v-card-text>
            <v-text-field v-model="form.email" class="pt-4" outlined prepend-icon="mdi-account-circle"
                          :error-messages="form.errors.get('email')" label="Email" required
            />
            <v-text-field v-model="form.password" class="pt-4" outlined prepend-icon="mdi-lock"
                          :error-messages="form.errors.get('password')" label="Password" type="password" required
            />
          </v-card-text>
          <v-divider />
          <v-card-actions>
            <v-btn class="pt-4 pb-4" block type="submit" color="primary" :loading="form.busy">
              Login
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'

export default {
  layout: 'basic',

  middleware: 'guest',

  metaInfo () {
    return { title: 'Login' }
  },

  data: () => ({
    form: new Form({
      email: 'admin@example.com',
      password: '123456'
    })
  }),

  methods: {
    async login () {
      try {
        // Submit the form.
        const { data } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', {
          token: data.access_token
        })

        // Fetch the user.
        await this.$store.dispatch('auth/fetchUser')

        // Redirect home.
        this.redirect()
      } catch (ex) {
        console.log(ex)
      }
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home' })
      }
    },

    fillWithAdmin () {
      this.form.fill({
        email: 'admin@example.com',
        password: '123456'
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.auth-wrapper {
  display: flex;
  min-height: calc(var(--vh, 1vh) * 100);
  width: 100%;
  flex-basis: 100%;
  align-items: center;

  // common style for both v1 and v2
  a {
    text-decoration: unset;
  }

  align-items: center;
  justify-content: center;
  overflow: hidden;
  padding: 1.5rem;

  .auth-inner {
    width: 32rem;
    z-index: 1;
  }
}
</style>
