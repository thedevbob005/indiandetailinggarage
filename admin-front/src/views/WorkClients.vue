<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <div class="text-h3">Clients</div>
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
                Total Clients
              </v-card-title>

              <v-card-subtitle class="mb-2">Total Clients</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">200</span></div>
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
                Active Clients
              </v-card-title>

              <v-card-subtitle class="mb-2">Clients active within last 30 days</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">37</span></div>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title class="d-flex">
            <v-responsive max-width="150">Client List</v-responsive>
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
            <template v-slot:item.isActive="{ item }">
              <v-switch v-model="item.columns.isActive" density="compact" color="success" hide-details></v-switch>
            </template>
            <template v-slot:item.action="{ item }">
              <v-btn-group border divided rounded density="compact" color="primary">
                <v-btn @click="$router.push('clients/history')">Orders</v-btn>
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
          { align: 'start', key: 'name', title: 'Title' },
          { key: 'phone', title: 'Phone' },
          { key: 'email', title: 'Email' },
          { key: 'isActive', title: 'Active' },
          { align: 'end', key: 'action', sortable: false, title: 'Action' }
        ],
        tableData: [
          {
            name: 'Jhon Smith',
            phone: '123456789',
            email: 'example1@domain.com',
            dob: '19/10/1989',
            isActive: true,
          },
          {
            name: 'Jhon Doe',
            phone: '223456789',
            email: 'example2@domain.com',
            dob: '25/10/1991',
            isActive: true,
          },
          {
            name: 'Will Smith',
            phone: '323456789',
            email: 'example3@domain.com',
            dob: '25/09/1968',
            isActive: true,
          },
          {
            name: 'Mark Hamilton',
            phone: '4123456789',
            email: 'example4@domain.com',
            dob: '03/04/1997',
            isActive: true,
          },
        ],
      }
    },
  }
</script>
