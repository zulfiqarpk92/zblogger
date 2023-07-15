<template>
  <v-card
    rounded="lg"
  >
    <v-card-title v-if="!blogId">
      Add Blog
    </v-card-title>
    <v-card-title v-if="blogId">
      Update Blog
    </v-card-title>
    <v-card-text>
      <form-alert :form="form" />
      <v-form class="multi-col-validation">
        <v-row>
          <v-col
            cols="12"
          >
            <v-text-field
              v-model="form.title"
              :rules="titleRules"
              :error-messages="form.errors.get('title')"
              label="Title"
              required
              outlined
              dense
              hide-details="auto"
            />
          </v-col>

          <v-col cols="12">
            <v-textarea
              v-model="form.body"
              label="Content"
              rows="6"
              outlined
            />
          </v-col>
          <v-col cols="12">
            <v-img :src="form.file" />
            <v-file-input
              v-model="form.file"
              show-size
              counter
              label="Image"
            />
          </v-col>

          <v-col cols="12">
            <v-btn
              color="primary"
              :loading="form.busy"
              :disabled="form.busy"
              @click="submitForm"
            >
              Submit
            </v-btn>
            <v-btn
              :to="{ name : 'blogs' }"
              type="reset"
              color="error"
              class="mx-2"
            >
              Cancel
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import Form from 'vform'
import FormAlert from '../../components/FormAlert.vue'

export default {
  components: { FormAlert },
  middleware: 'auth',
  props: {
    blogId: {
      type: Number,
      default: 0
    }
  },
  data: function () {
    return {
      loading: false,
      titleRules: [
        v => !!v || 'Title is required',
        v => v.length >= 10 || 'Title must be greater than 10 characters'
      ],
      form: new Form({
        title: '',
        body: '',
        file: null
      })
    }
  },
  mounted () {
    if (this.blogId) {
      this.loadData()
    }
  },
  methods: {
    loadData: function () {
      this.loading = true
      this.$http
        .get('/api/blogs/' + this.blogId)
        .then(({ data }) => {
          this.form = new Form({
            title: data.title,
            body: data.body,
            file: null
          })
          this.loading = false
        })
        .catch(error => {
          console.log(error)
          this.loading = false
        })
    },
    submitForm: function () {
      if (this.blogId) {
        this.form._method = 'PUT'
        this.form
          .post('/api/blogs/' + this.blogId)
          .then(({ data }) => {
            this.$store.dispatch('snackbar/showMessage', data.message)
            this.$router.push({ name: 'blogs' })
          })
          .catch(error => {
            if (error.response && error.response.data) {
              this.$set(this.form, 'errorMessage', error.response.data.message)
            }
            console.log(error)
          })
      } else {
        this.form
          .post('/api/blogs')
          .then(({ data }) => {
            this.$store.dispatch('snackbar/showMessage', data.message)
            this.$router.push({ name: 'blogs' })
          })
          .catch(error => {
            if (error.response && error.response.data) {
              this.$set(this.form, 'errorMessage', error.response.data.message)
            }
            console.log(error)
          })
      }
    }
  }
}
</script>
