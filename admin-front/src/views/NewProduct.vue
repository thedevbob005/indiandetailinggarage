<template>
  <v-container>
    <v-row>
      <v-col>
        <div class="text-h3">New Product</div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6">
        <v-text-field
          label="Product Code"
          single-line
          hint="Enter product code."
          v-model="productCode"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Product Name"
          single-line
          hint="Enter a name for the new product."
          v-model="productName"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick main image / poster"
          prepend-icon="mdi-camera"
          label="Poster / Image 1"
          v-model="productImage"
          ref="imagefile"
        ></v-file-input>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Short Description"
          single-line
          hint="Enter a short description for the product."
          v-model="productShort"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick image 2"
          prepend-icon="mdi-camera"
          label="Image 2"
          v-model="productImage02"
          ref="imagefile2"
        ></v-file-input>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Image 2 Short Description"
          single-line
          hint="Optional Short Description for Image 2"
          v-model="productImageDesc02"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick image 3"
          prepend-icon="mdi-camera"
          label="Image 3"
          v-model="productImage03"
          ref="imagefile3"
        ></v-file-input>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Image 3 Short Description"
          single-line
          hint="Optional Short Description for Image 3"
          v-model="productImageDesc03"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick image 4"
          prepend-icon="mdi-camera"
          label="Image 4"
          v-model="productImage04"
          ref="imagefile4"
        ></v-file-input>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Image 4 Short Description"
          single-line
          hint="Optional Short Description for Image 4"
          v-model="productImageDesc04"
        ></v-text-field>
      </v-col>
      <v-col cols="6">
        <v-file-input
          :rules="imgUploadRules"
          accept="image/png, image/jpeg, image/bmp"
          placeholder="Pick image 5"
          prepend-icon="mdi-camera"
          label="Image 5"
          v-model="productImage05"
          ref="imagefile5"
        ></v-file-input>
      </v-col>
      <v-col cols="6">
        <v-text-field
          label="Image 5 Short Description"
          single-line
          hint="Optional Short Description for Image 5"
          v-model="productImageDesc05"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="4">
        <v-text-field
          label="MRP"
          single-line
          hint="Enter a MRP for the product."
          v-model="productMRP"
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-text-field
          label="Price"
          single-line
          hint="Enter a price for the product."
          v-model="productPrice"
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-select
          label="Category"
          single-line
          hint="Select a category for the product."
          v-model="productCategory"
          :items="['Detailing', 'Modification']"
        ></v-select>
      </v-col>
      <v-col cols="8">
        <v-text-field
          label="URL Slug"
          single-line
          hint="Enter URL Slug (e.g. the-products-unique-name)."
          v-model="productSlug"
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-text-field
          label="Initial Inventory"
          type="number"
          single-line
          hint="Enter an initial inventory stock count for the product."
          persistent-hint
          v-model="productInventory"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="text-black">
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" @ready="editorReady"></ckeditor>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn @click="saveProduct">Save</v-btn>
        <v-btn variant="outline" color="error" @click="$router.push('../products')">Cancel</v-btn>
      </v-col>
    </v-row>
    <v-dialog
      v-model="dialog"
      width="auto"
      persistent
    >
      <v-card>
        <v-card-text>
          Product has been saved. Continue creating a new one?
        </v-card-text>
        <v-card-actions>
          <v-btn variant="text" color="grey" block @click="dialog = false">New</v-btn>
          <v-btn variant="text" color="green" block @click="dialog = false">Done</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
    }
  },
  data() {
    return {
      editorData: "<p>Product Description</p>",
      editor: ClassicEditor,
      editorConfig: {
        // The configuration of the editor.
      },
      imgUploadRules: [
        value => {
          return !value || !value.length || value[0].size < 2000000 || 'Image size should be less than 2 MB!'
        },
      ],
      productName: '',
      productCode: '',
      productShort: '',
      productDescription: '',
      productMRP: '',
      productPrice: '',
      productImage: null,
      productCategory: null,
      productSlug: '',
      productInventory: 0,
      productImage02: null,
      productImageDesc02: '',
      productImage03: null,
      productImageDesc03: '',
      productImage04: null,
      productImageDesc04: '',
      productImage05: null,
      productImageDesc05: '',
      dialog: false
    }
  },
  methods: {
    saveProduct () {
      let formData = new FormData();
      formData.append('image01', this.$refs['imagefile'].files[0]);
      if (this.productImage02) formData.append('image02', this.$refs['imagefile2'].files[0]);
      if (this.productImage03) formData.append('image03', this.$refs['imagefile3'].files[0]);
      if (this.productImage04) formData.append('image04', this.$refs['imagefile4'].files[0]);
      if (this.productImage05) formData.append('image05', this.$refs['imagefile5'].files[0]);
      formData.append('productName', this.productName);
      formData.append('productSlug', this.productSlug);
      formData.append('productCode', this.productCode);
      formData.append('productMRP', this.productMRP);
      formData.append('productPrice', this.productPrice);
      formData.append('productCategory', this.productCategory);
      formData.append('productShort', this.productShort);
      formData.append('productInventory', this.productInventory);
      formData.append('productDescription', this.editorData);
      formData.append('productImageDesc02', this.productImageDesc02);
      formData.append('productImageDesc03', this.productImageDesc03);
      formData.append('productImageDesc04', this.productImageDesc04);
      formData.append('productImageDesc05', this.productImageDesc05);
      this.axios.post('/products/new', formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then((response) => {
        // this.$router.push('../products');
        if(response.data.status === 'success') {
          this.dialog = true;
          // this.$router.push('../products');
        } else {
          alert(response.data.message);
        }
      });
    },
    newProduct () {
      this.productName = '';
      this.productCode = '';
      this.productShort = '';
      this.productDescription = '';
      this.productMRP = '';
      this.productPrice = '';
      this.productImage = null;
      this.productCategory = null;
      this.productSlug = '';
      this.productInventory = 0;
      this.productImage02 = null;
      this.productImageDesc02 = '';
      this.productImage03 = null;
      this.productImageDesc03 = '';
      this.productImage04 = null;
      this.productImageDesc04 = '';
      this.productImage05 = null;
      this.productImageDesc05 = '';
      this.editorData = "<p>Product Description</p>";
      this.dialog = false;
    },
    doneHere () {
      this.dialog = false;
      this.$router.push('../products');
    }
  }
}
</script>
