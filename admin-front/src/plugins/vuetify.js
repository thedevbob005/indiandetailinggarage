/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Composables
import { createVuetify } from 'vuetify'
import { VDataTable } from 'vuetify/labs/VDataTable'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  components: {
    VDataTable,
  },
  theme: {
    defaultTheme: 'dark',
    themes: {
      dark: {
        primary: '#10163a',
        secondary: '#262b44',
        info: '#5b52c5',
        accent: '#ea5455',
      },
      light: {
        colors: {
          primary: '#1867C0',
          secondary: '#5CBBF6',
        },
      },
    },
  },
})
