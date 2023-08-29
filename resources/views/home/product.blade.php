@extends('layout.home')

@section('title','Product')

@section('content')

<!-- Single Product -->
<section class="section-wrap pb-40 single-product">
  <div class="container-fluid semi-fluid">
    <div class="row">

      <div class="col-md-6 col-xs-12 product-slider mb-60">

        <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main">

          <div class="gallery-cell">
            <a href="/uploads/{{$product->gambar}}" class="lightbox-img">
              <img src="/uploads/{{$product->gambar}}" alt="" />
              <i class="ui-zoom zoom-icon"></i>
            </a>
          </div>
        </div> 


      </div> <!-- end col img slider -->
      @if ($product)


      <div class="col-md-6 col-xs-12 product-description-wrap">
        <ol class="breadcrumb">
          <li>
            <a href="/">Home</a>
          </li>
          <li>
            <a href="/products/{{$product->id_subkategori}}">{{$product->subcategory->nama_subkategori}}</a>
          </li>
          <li class="active">
            Catalog
          </li>
        </ol>
        <h1 class="product-title">{{$product->nama_produk}}</h1>
        <span class="price">
          <ins>
            <span class="amount">Rp. {{number_format($product->harga)}}</span>
          </ins>
        </span>
        <!-- <p class="short-description">{{$product->deskripsi}}</p> -->





        <div class="product-actions">
          <span>Qty:</span>

          <div class="quantity buttons_added">
          <input type="number" step="1" min="0" max="{{$product->qty}}" value="1" title="Qty" class="input-text jumlah qty text" />
            <div class="quantity-adjust">
              <a href="#" class="plus">
                <i class="fa fa-angle-up"></i>
              </a>
              <a href="#" class="minus">
                <i class="fa fa-angle-down"></i>
              </a>
            </div>
          </div>

          <a href="#" class="btn btn-dark btn-lg add-to-cart"><span>Add to Cart</span></a>

          <a href="#" class="product-add-to-wishlist"><i class="fa fa-heart"></i></a>
        </div>


        <div class="product_meta">
          @if ($product->category)
          <span class="brand_as">Category: <a href="#">{{$product->category->nama_kategori}}</a></span>
          @endif
          <span class="posted_in">Tags: <a href="#">{{$product->tags}}</a></span>
        </div>

        <!-- Accordion -->
        <div class="panel-group accordion mb-50" id="accordion">
          <div class="panel">
            <div class="panel-heading">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="minus">Description<span>&nbsp;</span>
              </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                {{$product->deskripsi}}
              </div>
            </div>
          </div>

      

        <div class="socials-share clearfix">
          <span>Share:</span>
          <div class="social-icons nobase">
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-google"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
          </div>
        </div>
      </div> <!-- end col product description -->
    </div> <!-- end row -->

  </div> <!-- end container -->
</section> <!-- end single product -->


<!-- Related Products -->
<section class="section-wrap pt-0 shop-items-slider">
  <div class="container">
    <div class="row heading-row">
      <div class="col-md-12 text-center">
        <h2 class="heading bottom-line">
          Latest Products
        </h2>
      </div>
    </div>

    <div class="row">

      <div id="owl-related-items" class="owl-carousel owl-theme">
        @foreach ($latest_products as $produk)
        <div class="product">
          <div class="product-item hover-trigger">
            <div class="product-img">
              <a href="/product/{{$produk->id}}">
                <img src="/uploads/{{$produk->gambar}}" alt="">
                <img src="/uploads/{{$produk->gambar}}" alt="" class="back-img">
              </a>
              <div class="product-label">
                <span class="sale">sale</span>
              </div>
              <div class="hover-2">
                <div class="product-actions">
                  <a href="#" class="product-add-to-wishlist">
                    <i class="fa fa-heart"></i>
                  </a>
                </div>
              </div>
              <a href="/product/{{$produk->id}}" class="product-quickview">More</a>
            </div>
            <div class="product-details">
              <h3 class="product-title">
                <a href="/product/{{$produk->id}}">{{$produk->nama_produk}}</a>
              </h3>
              <span class="category">
                <a href="/products/{{$produk->id_subkategori}}">{{$produk->subcategory->nama_subkategori}}</a>
              </span>
            </div>
            <span class="price">
              <ins>
                <span class="amount">Rp. {{number_format($produk->harga)}}</span>
              </ins>
            </span>
          </div>
        </div>

        @endforeach
      </div> <!-- end slider -->
      @endif
    </div>
  </div>
</section> <!-- end related products -->
@endsection


@push('js')
<script>
  $(function(){
    $('.add-to-cart').click(function(e){
        e.preventDefault();

        var id_member = {{ Auth::guard('webmember')->user()->id }};
        var id_produk = {{ $product->id }};
        var qty = $('.jumlah').val();
        total = {{$product->harga}}*qty;
        var is_checkout = 0;

        var data = {
            id_member: id_member,
            id_produk: id_produk,
            qty: qty,
            total: total,
            is_checkout: is_checkout,
        };

        // console.log('{!! $product !!}')

        $.ajax({
            url: '/add_to_cart',
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: data,
            success: function(response){
                window.location.href = '/cart';
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });
  });

 // Fungsi untuk memastikan nilai "Qty" tidak melebihi nilai "qty" dari database
 function validateQuantity() {
        var quantityElements = document.querySelectorAll('.jumlah');

        quantityElements.forEach(el => {
            var quantityValue = parseInt(el.value);
            var maxQuantity = {{$product->qty}};

            if (quantityValue > maxQuantity) {
                alert("Qty More Than Stock!");
                el.value = maxQuantity; // Set nilai "Qty" ke nilai maksimum yang diizinkan
            }
        });
    }

    // Menambahkan event listener untuk memanggil fungsi validateQuantity() saat nilai "Qty" berubah
    var quantityInputs = document.querySelectorAll('.jumlah');
    quantityInputs.forEach(el => {
        el.addEventListener('change', validateQuantity);
    });
  
</script>
@endpush
