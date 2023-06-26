class Product {
    constructor({ name, categories, description, images, date_and_time }) {
      this.name = name;
      this.categories = categories;
      this.description = description;
      this.images = images;
      this.dateAndTime = date_and_time;
    }
  
    toFormData() {
      const formData = new FormData();
      for (const [key, value] of Object.entries(this)) {
        if (key === "categories") {
          formData.append(key, value);
        } else if (key === "images") {
          for (const image of value) {
            formData.append("images[]", image);
          }
        } else {
          formData.append(key, value);
        }
      }
      return formData;
    }
  }
  
  export default Product;