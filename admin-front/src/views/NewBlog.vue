<template>
  <v-container>
    <v-row>
      <v-col>
        <div class="text-h3">New Blog</div>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-text-field
          label="Blog Title"
          single-line
          hint="Enter a short title for the new blog post."
          v-model="title"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-combobox
          clearable
          chips
          multiple
          label="Tags"
          hint="Enter tags for the new blog post."
          v-model="tags"
          :items="['Superfood', 'Nutrition', 'Recepie', 'Smoothie', 'Preventative Mesure', 'Skin Care']"
        ></v-combobox>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-text-field
          label="URL Slug"
          single-line
          hint="Enter URL Slug (e.g. the-blog-post-title)."
          v-model="slug"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick main image / poster"
          prepend-icon="mdi-camera"
          label="Poster"
          v-model="poster"
          ref="posterfile"
        ></v-file-input>
      </v-col>
      <v-col>
        <v-text-field
          label="Short Description"
          single-line
          hint="Enter a short description for the new blog post."
          v-model="shortDesription"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" @ready="editorReady"></ckeditor>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn @click="saveBlog">Save</v-btn>
        <v-btn variant="outline" color="error" @click="$router.push('../blogs')">Cancel</v-btn>
      </v-col>
    </v-row>
    <pre>
      {{ poster }}
    </pre>
  </v-container>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
import '../../ckeditor5/build/ckeditor.js'

export default {
  components: {
      // Use the <ckeditor> component in this view.
      ckeditor: CKEditor.component
  },
  methods: {
    editorReady (editor) {
      const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

      toolbarContainer.appendChild( editor.ui.view.toolbar.element );

      window.editor = editor;
    },
    saveBlog () {
      let formData = new FormData();
      formData.append('poster', this.$refs['posterfile'].files[0]);
      formData.append('title', this.title);
      formData.append('slug', this.slug);
      formData.append('tags', this.tags.join(','));
      formData.append('shortdescription', this.shortDesription);
      formData.append('content', this.editorData);
      this.axios.post('/blog/new', formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then((response) => {
        // this.$router.push('../blogs');
        if(response.data.status === 'success') {
          alert(response.data.message);
          this.$router.push('../blogs');
        } else {
          alert(response.data.message);
        }
      });
    }
  },
  data() {
    return {
      editor: ClassicEditor,
      editorData: '<p>Type your content here.</p>',
      editorConfig: {
        // The configuration of the editor.
      },
      imgUploadRules: [
        value => {
          return !value || !value.length || value[0].size < 2000000 || 'Image size should be less than 2 MB!'
        },
      ],
      title: '',
      tags: [],
      slug: '',
      poster: null,
      shortDesription: ''
    }
  }
}
</script>
