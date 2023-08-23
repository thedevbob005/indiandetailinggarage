<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <div class="text-h3">Products</div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6" md="4" lg="3">
        <v-card
          color="#f2f2f2"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h6">
                Products
              </v-card-title>

              <v-card-subtitle class="mb-2">Total Products</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">80</span></div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3" xl="2">
        <v-card
          color="#f2f2f2"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h6">
                Active Products
              </v-card-title>

              <v-card-subtitle class="mb-2">Products shown on website.</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">56</span></div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3" xl="2">
        <v-card
          color="#f2f2f2"
          @click="$router.push('products/new')"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h6">
                Add
              </v-card-title>

              <v-card-subtitle class="mb-2">Add new product.</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4"></span></div>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title class="d-flex">
            <v-responsive max-width="150">Product List</v-responsive>
            <v-spacer></v-spacer>
            <v-responsive max-width="300">
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                density="compact"
              ></v-text-field>
            </v-responsive>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="tableData"
            :search="search"
          >
            <template v-slot:item.images="{ item }">
              <div class="d-flex">
                <v-responsive width="40" class="mr-1">
                  <v-img :src="axios.defaults.baseURL + '/../uploads/' + item.raw.image01"></v-img>
                </v-responsive>
                <v-responsive width="40" class="mr-1" v-if="item.raw.image02.length > 0">
                  <v-img :src="axios.defaults.baseURL + '/../uploads/' + item.raw.image02"></v-img>
                </v-responsive>
                <v-responsive width="40" class="mr-1" v-if="item.raw.image03.length > 0">
                  <v-img :src="axios.defaults.baseURL + '/../uploads/' + item.raw.image03"></v-img>
                </v-responsive>
                <v-responsive width="40" class="mr-1" v-if="item.raw.image04.length > 0">
                  <v-img :src="axios.defaults.baseURL + '/../uploads/' + item.raw.image04"></v-img>
                </v-responsive>
                <v-responsive width="40" class="mr-1" v-if="item.raw.image05.length > 0">
                  <v-img :src="axios.defaults.baseURL + '/../uploads/' + item.raw.image05"></v-img>
                </v-responsive>
              </div>
            </template>
            <template v-slot:item.active="{ item }">
              <v-switch v-model="item.columns.active" density="compact" color="success" hide-details @update:modelValue="toggleActive(item.columns.product_id)"></v-switch>
            </template>
            <template v-slot:item.price="{ item }">
              <span style="text-decoration: line-through;">₹{{ item.raw.mrp }}</span>&nbsp;&nbsp;&nbsp;
              ₹{{ item.raw.price }}
            </template>
            <template v-slot:item.action="{ item }">
              <v-btn-group border divided rounded density="compact" color="primary">
                <v-btn>Edit</v-btn>
                <v-btn>Delete</v-btn>
              </v-btn-group>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          { align: 'start', key: 'product_id', title: 'ID' },
          { key: 'images', title: 'Product Images' },
          { key: 'name', title: 'Product Name' },
          { key: 'price', title: 'Price' },
          { key: 'active', title: 'Active' },
          { align: 'end', key: 'action', sortable: false, title: 'Action' }
        ],
        tableData: [],
      }
    },
    mounted () {
      this.axios.get('/products').then((response) => {
        if (response.data.status === 'success') {
          // change value of key 'active' to true or false based on its current value of 0 or 1 and for every row returned in response.data.data
          response.data.data.forEach(item => {
            item.active = item.active === "1" ? true : false
          })
          
          this.tableData = response.data.data
          console.log(this.tableData)
        } else {
          this.tableData = [];
        }
      })
    },
    methods: {
      toggleActive (id) {
        this.axios.get('/products/toggleactive/' + id).then((response) => {
          if (response.data.status === 'success') {
            // change value of key 'active' to true or false based on its current value of 0 or 1 and for every row returned in response.data.data
            response.data.data.forEach(item => { item.active = item.active === "1" ? true : false })
            this.tableData = response.data.data
          }
        })
      },
      openInNewTab(url) {
        window.open(url, '_blank', 'noreferrer');
      },
    }
  }
</script>
