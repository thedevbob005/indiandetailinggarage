<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <div class="text-h3">Blogs</div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6" md="4" lg="3" xl="2">
        <v-card
          color="#f2f2f2"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h5">
                Blogs
              </v-card-title>

              <v-card-subtitle class="mb-2">Active blog posts</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">2</span></div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3" xl="2">
        <v-card
          color="#f2f2f2"
          @click="$router.push('blogs/new')"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h5">
                Add
              </v-card-title>

              <v-card-subtitle class="mb-2">Create new blog post</v-card-subtitle>

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
            <v-responsive max-width="150">Blog List</v-responsive>
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
            <template v-slot:item.title="{ item }">
              <strong>{{ item.columns.title }} </strong>
              <small>{{ item.columns.shortdescription }}</small>
            </template>
            <template v-slot:item.active="{ item }">
              <v-switch v-model="item.columns.active" density="compact" color="success" hide-details @update:modelValue="toggleActive(item.columns.blog_id)"></v-switch>
            </template>
            <template v-slot:item.created="{ item }">
              {{ new Date(item.columns.created).toISOString().substr(0, 10) }}
            </template>
            <template v-slot:item.action="{ item }">
              <v-btn-group border divided rounded density="compact" color="primary">
                <v-btn @click="openInNewTab(axios.defaults.baseURL + '/../blog/' + item.raw.slug, '_blank')">View</v-btn>
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
          {
            align: 'start',
            key: 'blog_id',
            sortable: false,
            title: 'ID',
          },
          { key: 'title', title: 'Title' },
          { key: 'created', title: 'Date' },
          { key: 'active', title: 'Active', sortable: false },
          { align: 'end', key: 'action', sortable: false, title: 'Action' }
        ],
        tableData: [],
      }
    },
    mounted () {
      this.axios.get('/blog').then((response) => {
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
        this.axios.get('/blog/toggleactive/' + id).then((response) => {
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
