<template>
  <v-card class="text-center py-10">
    <h3 class="mb-4">
      Page Not Found
    </h3>

    <div class="links">
      <router-link :to="{ name: 'welcome' }">
        Go Home
      </router-link>
    </div>
  </v-card>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
