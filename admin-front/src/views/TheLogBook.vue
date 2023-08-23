<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <div class="text-h3">The Log Book</div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6" md="4" lg="3">
        <v-card color="#fafafa">
          <v-card-title class="text-h5 lower-lh">
            Client
          </v-card-title>
          <v-select
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
            density="compact"
            hide-details
            bg-color="transparent"
            elevation="0"
          ></v-select>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3">
        <v-card color="#fafafa">
          <v-card-title class="text-h5 lower-lh">
            Project
          </v-card-title>
          <v-select
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
            density="compact"
            hide-details
            bg-color="transparent"
            elevation="0"
          ></v-select>
        </v-card>
      </v-col>
      <v-col cols="6" md="4" lg="3">
        <v-card color="#fafafa">
          <div class="d-flex flex-no-wrap justify-space-between">
            <div class="card-left-block">
              <v-card-title class="text-h5">
                Add Log
              </v-card-title>
              <v-card-subtitle>Add a new log entry.</v-card-subtitle>
            </div>
            <v-avatar
              size="72"
              class="mb-2 mr-2"
              rounded="0"
            ><span class="text-h4 mdi mdi-note-plus-outline"></span></v-avatar>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>
            Logs
          </v-card-title>
          <v-list :max-height="400">
            <v-list-item class="py-0" v-for="(log, index) in filteredLogs" :key="index">
              <v-divider></v-divider>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" md="4" lg="3" xl="2">
                    <div class="text-subtitle-2">Date</div>
                    <div class="text-body-1 mb-2">{{ log.log_on }}</div>
                    <div class="text-subtitle-2">Company / Client</div>
                    <div class="text-body-1 mb-2">{{ log.company }}</div>
                    <div class="text-subtitle-2">Project</div>
                    <div class="text-body-1">{{ log.project }} <v-chip v-if="log.is_amc" size="x-small" class="ma-1">AMC Project</v-chip></div>
                  </v-col>
                  <v-col cols="12" md="4" lg="5" xl="6">
                    <div class="text-subtitle-1">Description</div>
                    <p>{{ log.description }}</p>
                  </v-col>
                  <v-col cols="12" md="4" lg="3" xl="3">
                    <div class="text-subtitle-1">Links</div>
                    <ol class="ml-5">
                      <li v-for="link in log.links" :key="link.link"><a :href="link.link" target="_blank" rel="noopener noreferrer">{{ link.title }}</a></li>
                    </ol>
                  </v-col>
                </v-row>
                <v-divider color="info" class="my-2"></v-divider>
                <v-row>
                  <v-col cols="12">
                    <v-chip v-for="chip in log.tags" :key="chip" size="small" class="ma-1">{{ chip }}</v-chip>
                  </v-col>
                </v-row>
              </v-container>
              <v-divider></v-divider>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
//
const date = new Date()
export default {
  data () {
    return {
      filteredLogs: [
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
        {
          log_type: 'project_start',
          log_on: date.toDateString(),
          company: 'The Good Cow Company',
          project: 'Website',
          description: 'Minor Textual Changes.',
          is_amc: true,
          links: [
            { title: 'website', link: 'https://thegoodcowcompany.com' },
            { title: 'software', link: 'https://www.thegoodcowcompany.com/crm/login' },
          ],
          tags: [ 'tgcc', 'minor change' ]
        },
      ],
    }
  }
}
</script>
  
<style>
.lower-lh {
  line-height: 1.55rem !important;
}
</style>
  