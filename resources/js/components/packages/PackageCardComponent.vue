<template>
<div class="row">
    <div class="col-lg-12 m-b-10 m-t-10">
        <div class="form-group form-group-default">
            <label>Search Package</label>
            <input type="search" id="search-package" class="form-control" >
        </div>
    </div>


    <div class="col-lg-6 pkg"  v-for="package_ in packages">
      <div id="card-linear-color" class="card card-default card-address">
        <div class="card-header  ">
            <div class="card-title col-lg-12">
                <span class="pull-left"><b>Tracking # </b>: {{package_.tracking_number}}</span>

                <span class="pull-right"><b>ID </b>: {{package_.package_id}}</span>
                
            </div>
           
            <hr class="m-b-0"/>
        </div>
        <div class="card-body">
           
                    
        <div class="preview-pic row m-b-10">
            <div class="col-lg-6" id="pic-1" v-for="image in package_.images">
                <img :src="'https://s3.amazonaws.com/uploads-gshopaholics/'+image.image_name" class="img-fluid  img-thumbnail"/>
            </div>
            
            
        </div>
                    
    
    <div class="details col-md-12">
        <h3 class="product-title">men's shoes fashion</h3>
        <div class="rating">
            <div class="stars">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
            <span class="review-no">41 reviews</span>
        </div>
        <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
        <h4 class="price">current price: <span>$180</span></h4>
        <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
        <h5 class="sizes">sizes:
            <span class="size" data-toggle="tooltip" title="small">s</span>
            <span class="size" data-toggle="tooltip" title="medium">m</span>
            <span class="size" data-toggle="tooltip" title="large">l</span>
            <span class="size" data-toggle="tooltip" title="xtra large">xl</span>
        </h5>
        <h5 class="colors">colors:
            <span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
            <span class="color green"></span>
            <span class="color blue"></span>
        </h5>
        <div class="action">
            <button class="add-to-cart btn btn-default" type="button">add to cart</button>
            <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
        </div>
    </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary pull-right"  :data-id="package_.id" @click="showSplitModal()" >Details</button>
        </div>
      </div>
    </div>

    <div class="clearfix"></div>
    
       

</div>



</template>

<script>
   //import split from './split-modal.vue'
    export default {
     data(){
            return{
                packages:[],
                //showModal:'',
            }
        },
        methods:{
            fetch() {
                axios.get(gs_window.ajaxPackagesJson)
                    .then((response) => {
                    
                        this.packages = response.data.packages;
                    });
            },
            showSplitModal(){
                console.log('emit event');
                this.$root.$emit('showSplitModal');
            },
            
        },
        mounted() {
           
           this.fetch();
           
        },
        components: {
            //split
          }
    }
</script>
