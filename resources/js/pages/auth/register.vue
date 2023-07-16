<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card height="100%" width="100%" class="ml-auto py-4 px-6">
        <v-card-title class="d-flex align-center justify-center">
          <router-link to="/" class="d-flex align-center">
            <h2 class="text-2xl font-weight-semibold">
              My CMS
            </h2>
          </router-link>
        </v-card-title>

        <v-form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <v-card-text>
            <v-text-field v-model="form.name" class="pt-4" outlined prepend-icon="mdi-account-circle"
                          :error-messages="form.errors.get('name')" label="Name" required
            />
            <v-text-field v-model="form.email" class="pt-4" outlined prepend-icon="mdi-account-circle"
                          :error-messages="form.errors.get('email')" label="Email" required
            />
            <v-text-field v-model="form.password" class="pt-4" outlined prepend-icon="mdi-lock"
                          :error-messages="form.errors.get('password')" label="Password" type="password" required
            />
            <v-text-field v-model="form.password_confirmation" class="pt-4" outlined prepend-icon="mdi-lock"
                          :error-messages="form.errors.get('password_confirmation')" label="Confirm Password" type="password"
                          required
            />
          </v-card-text>
          <v-divider />
          <v-card-actions class="flex flex-column">
            <v-btn class="pt-4 pb-4" block type="submit" color="primary" :loading="form.busy">
              Register
            </v-btn>
            <div class="align-left mt-4">Already have an account? Click <router-link to="/login">here</router-link> to login.</div>
          </v-card-actions>
        </v-form>
      </v-card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  layout: 'basic',

  middleware: 'guest',

  metaInfo () {
    return { title: 'Register' }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.access_token) {

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token: data.access_token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      }
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
