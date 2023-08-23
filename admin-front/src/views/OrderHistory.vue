<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <div class="text-h3">[client name goes here]</div>
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
                Orders
              </v-card-title>

              <v-card-subtitle class="mb-2">Orders since the beginning</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">20</span></div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3">
        <v-card
          color="#f2f2f2"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h6">
                This Month
              </v-card-title>

              <v-card-subtitle class="mb-2">Orders This Month</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">5</span></div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3">
        <v-card
          color="#f2f2f2"
        >
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="text-h6">
                New Orders
              </v-card-title>

              <v-card-subtitle class="mb-2">Orders that have not been shipped</v-card-subtitle>

            </div>

            <div class="mr-3 my-4"><span class="text-h4">3</span></div>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title class="d-flex">
            <v-responsive max-width="150">Order List</v-responsive>
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
            <template v-slot:item.order="{ item }">
              <div v-for="orderItem in item.columns.order">{{ orderItem.itemID }} {{ orderItem.itemName }} [{{ orderItem.itemVariant }}] ✖ {{ orderItem.qty }}</div>
            </template>
            <template v-slot:item.status="{ item }">
              <span v-if="item.columns.status===0" class="text-primary">New</span>
              <span v-if="item.columns.status===1" class="text-success">Shipped</span>
              <span v-if="item.columns.status===2" class="text-error">Cancelled</span>
            </template>
            <template v-slot:item.action="{ item }">
              <v-btn-group border divided rounded density="compact" color="primary">
                <v-btn @click="showDetails(item.columns)">Details</v-btn>
                <v-btn>Print</v-btn>
                <v-menu>
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                    >
                      Update
                    </v-btn>
                  </template>
                  <v-list>
                    <v-list-item>
                      <v-list-item-title>Set Status: New</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>Set Status: Shipped</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>Set Status: Cancelled</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </v-btn-group>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <v-dialog
    v-model="dialog"
    width="auto"
  >
    <v-card>
      <v-card-text>
        <div class="text-h5">
          #{{ dialogData.orderID }} &nbsp;&nbsp;
          <v-chip v-if="dialogData.status===0" border density="compact" color="primary">New</v-chip>
          <v-chip v-if="dialogData.status===1" border density="compact" color="success">Shipped</v-chip>
          <v-chip v-if="dialogData.status===2" border density="compact" color="error">Cancelled</v-chip>
        </div>
        <div class="text-h6">Client</div>
        {{ dialogData.client.name }}<br />
        {{ dialogData.client.phone }}<br />
        {{ dialogData.client.email }}
        <div class="text-h6">Order</div>
        <div v-for="orderItem in dialogData.order">{{ orderItem.itemID }} {{ orderItem.itemName }} [{{ orderItem.itemVariant }}] ✖ {{ orderItem.qty }}</div>
        <div class="text-h6">Bill Total</div>
        USD ${{ dialogData.bill }}
        <div class="text-h6">Shipping Address</div>
        {{ dialogData.shipping.building }}, {{ dialogData.shipping.road }}<br />
        {{ dialogData.shipping.postalcode }}, {{ dialogData.shipping.city }}<br />
        {{ dialogData.shipping.state }}, {{ dialogData.shipping.country }}
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        dialogData: {
          orderID: null,
          status: null,
          client: {
            name: 'Jhon Doe',
            phone: '223456789',
            email: 'example2@domain.com',
          },
          order: [
            {
              itemID: null,
              itemName: null,
              itemVariant: null,
              qty: null
            }
          ],
          bill: null,
          shipping: {
            building: '221B',
            road: 'Baker St',
            postalcode: 'NW1 6XE',
            city: 'London',
            state: 'London',
            country: 'UK',
          }
        },
        search: '',
        headers: [
          { align: 'start', key: 'id', title: 'Order ID' },
          { key: 'order', title: 'Ordered Items' },
          { key: 'bill', title: 'Bill' },
          { key: 'status', title: 'Status' },
          { align: 'end', key: 'action', sortable: false, title: 'Action' }
        ],
        tableData: [
          {
            id: '2305210001',
            order: [
              {
                itemID: 1,
                itemName: 'Product 1',
                itemVariant: '200g',
                qty: 2
              },
              {
                itemID: 3,
                itemName: 'Product 3',
                itemVariant: '500g',
                qty: 1
              }
            ],
            bill: 230.00,
            status: 1,
          },
          {
            id: '2305210002',
            order: [
            {
                itemID: 1,
                itemName: 'Product 1',
                itemVariant: '200g',
                qty: 1
              },
              {
                itemID: 2,
                itemName: 'Product 2',
                itemVariant: '500g',
                qty: 2
              },
              {
                itemID: 3,
                itemName: 'Product 3',
                itemVariant: '200g',
                qty: 2
              }
            ],
            bill: 590.00,
            status: 0,
          },
          {
            id: '2305210003',
            order: [
              {
                itemID: 1,
                itemName: 'Product 1',
                itemVariant: '200g',
                qty: 2
              },
              {
                itemID: 3,
                itemName: 'Product 3',
                itemVariant: '500g',
                qty: 1
              }
            ],
            bill: 230.00,
            status: 2,
          },
        ],
      }
    },
    methods: {
      showDetails (details) {
        console.log(details)
        this.dialogData.orderID = details.id
        this.dialogData.order = details.order
        this.dialogData.bill = details.bill
        this.dialogData.status = details.status
        this.dialog = true
      }
    }
  }
</script>
