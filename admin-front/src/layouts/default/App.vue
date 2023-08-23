<template>
  <v-app>
    <v-app-bar title="IDG Admin" :elevation="1">
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      </template>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer">
      <v-sheet
        color="grey-darken-4"
        class="pa-2"
      >
        <v-avatar
          color="grey-darken-1"
          image="https://ui-avatars.com/api/?name=John+Doe&background=random&size=72"
          size="72"
          class="float-left mr-2"
        ></v-avatar>

        <div class="chippedText mb-1">
          <span class="text-h6">John Doe</span><br />
          <small>CEO</small><br />
          <small>john.doe@example.com</small>
        </div>
        <v-btn block small text flat class="mt-2">Logout</v-btn>
      </v-sheet>
      <v-divider></v-divider>
      <v-list :lines="false" density="compact" nav v-for="(menu, i) in menus" :key="i">
        <v-list-subheader>{{ menu.header }}</v-list-subheader>
        <v-list-item type="link" :prepend-icon="item.icon" :title="item.name" :to="item.to" v-for="(item, ii) in menu.items" :key="ii"></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<style>
.chippedText {
  line-height: normal;
}
</style>

<script>
  export default {
    data: () => ({
      drawer: null,
      menus: [
        {
          header: 'DASHBOARD',
          items: [
            { name: 'Dashboard', icon: 'mdi-view-dashboard-outline', to: '/dashboard' }
          ]
        },
        {
          header: 'WEBSITE',
          items: [
            { name: 'Blogs', icon: 'mdi-post-outline', to: '/website/blogs' },
          ]
        },
        {
          header: 'ECOMMERCE',
          items: [
            { name: 'Clients', icon: 'mdi-account-group-outline', to: '/ecommerce/clients' },
            { name: 'Products', icon: 'mdi-briefcase-outline', to: '/ecommerce/products' },
            { name: 'Orders', icon: 'mdi-book-open-outline', to: '/ecommerce/orders' },
          ]
        },
        {
          header: 'REPORTS [TBD]',
          items: [
            { name: 'Sales', icon: 'mdi-chart-bar', to: '/reports/clients' },
            { name: 'Demand', icon: 'mdi-chart-bar', to: '/reports/products' },
          ]
        },
      ],
    }),
  }
</script>
