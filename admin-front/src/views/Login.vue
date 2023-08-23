<template>
  <v-container fluid class="pa-0" style="background-image: url(https://source.unsplash.com/random/1920x1080?background); background-size: cover; background-repeat: no-repeat; background-position: center;">
    <v-row no-gutters align="center" justify="center" style="height: 100dvh;">
      <v-col :cols="12" :md="6" :lg="5" :xl="4" :xxl="3" align-self="center">
        <v-form v-model="valid" @submit.prevent="doLogin">
          <v-card
            prepend-icon="mdi-account-key-outline"
          >
            <template v-slot:title>
              Login
            </template>

            <v-card-text>
              <v-text-field
              v-model="username"
              :rules="nameRules"
              :counter="10"
              label="Username / Email"
              required
            ></v-text-field>
            <v-text-field
              v-model="userpass"
              :rules="passwordRules"
              label="Password"
              type="password"
              required
            ></v-text-field>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                variant="text"
                type="submit"
              >
                LOGIN
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import router from '@/router'

  export default {
    data: () => ({
      valid: false,
      username: '',
      userpass: '',
      nameRules: [
        value => {
          if (value) return true

          return 'Name is requred.'
        },
      ],
      passwordRules: [
        value => {
          if (value) return true

          return 'Password is requred.'
        },
        
      ],
    }),
    methods: {
      doLogin() {
        router.push({name: 'DashboardHome'})
      }
    }
  }
</script>
