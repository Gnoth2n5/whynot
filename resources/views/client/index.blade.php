@extends('layouts.client')
@section('content-client')
<style>
  .product-name{
    min-height: 38px;
  }
</style>
    <!-- =====  BANNER STRAT  ===== -->
    <div class="banner">
      <div class="main-banner owl-carousel">
        <div class="item">
          <a href="#">
            <img src="{{ asset('asset/client/images/main_banner1.jpg') }}" alt="Main Banner" class="img-responsive" />
          </a>
        </div>
      </div>
    </div>
    <!-- =====  BANNER END  ===== -->
    <!-- =====  CONTAINER START  ===== -->
    <div class="container">
      <div class="row ">
        <div class="col-sm-12 mtb_10">
          <!-- =====  PRODUCT TAB  ===== -->
          <div id="product-tab" class="mt_50">
            <div class="heading-part mb_10 ">
              <h2 class="main_title">Sản Phẩm Bán Chạy</h2>
            </div>
            <div class="tab-content clearfix box">
              <div class="tab-pane active" id="nArrivals">
                <div class="nArrivals owl-carousel">
                  @foreach ($bellingProducts as $bellingProduct)
                    <div class="product-grid">
                      <div class="item">
                        <div class="product-thumb">
                          <div class="image product-imageblock"> 
                              <a href="{{ route('user.products_detail', $bellingProduct->id) }}"> 
                                <img 
                                  style="object-fit: contain;"
                                  data-name="product_image" 
                                  src="{{ asset("asset/client/images/products/small/$bellingProduct->img") }}" 
                                  alt="iPod Classic"
                                  title="iPod Classic" 
                                  class="img-responsive product-thumb__img-product">
                                <img 
                                  style="object-fit: contain;"
                                  src="{{ asset("asset/client/images/products/small//$bellingProduct->img") }}"
                                  alt="iPod Classic" 
                                  title="iPod Classic" 
                                  class="img-responsive product-thumb__img-product"> 
                              </a>
                          </div>
                          <div class="caption product-detail text-center">
                            <div class="rating"> 
                              <x-avg-stars :number="$bellingProduct->avg_rating" />
                            </div>
                            <h6 data-name="product_name" class="product-name">
                              <a href="{{ route('user.products_detail', $bellingProduct->id) }}" title="Casual Shirt With Ruffle Hem">{{ $bellingProduct->name }}</a>
                            </h6>
                            <span class="price"><span class="amount"><span class="currencySymbol"></span>{{ format_number_to_money($bellingProduct->price_sell) }} VNĐ </span>
                            </span>
                          </div>
                          <div class="button_group">
                            <a href="{{ route('user.products_detail', $bellingProduct->id) }}" class="btn btn-primary" type="button">Xem Chi Tiết</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <!-- =====  PRODUCT TAB  END ===== -->
          <!-- =====  PRODUCT TAB  ===== -->
          <div id="product-tab" class="mt_50">
            <div class="heading-part mb_10 ">
              <h2 class="main_title">Sản Phẩm Mới Nhất</h2>
            </div>
            <div class="tab-content clearfix box">
              <div class="tab-pane active" id="nArrivals">
                <div class="tab-pane" id="Featured">
                  <div class="Featured owl-carousel">
                    @foreach ($newProducts as $newProduct)
                    <div class="product-grid">
                      <div class="item">
                        <div class="product-thumb  mb_30">
                          <div class="image product-imageblock">
                            <a href="{{ route('user.products_detail', $newProduct->id) }}">
                              <img
                              style="object-fit: contain;"
                              data-name="product_image" 
                              src="{{ asset("asset/client/images/products/small/$newProduct->img") }}" 
                              alt="iPod Classic"
                              title="iPod Classic" 
                              class="img-responsive product-thumb__img-product">
                              <img src="{{ asset("asset/client/images/products/small/$newProduct->img") }}"
                              style="object-fit: contain;"
                                  alt="iPod Classic" 
                                  title="iPod Classic" 
                                  class="img-responsive product-thumb__img-product">
                            </a>
                          </div>
                          <div class="caption product-detail text-center">
                            <div class="rating">
                              <x-avg-stars :number="$newProduct->avg_rating" />
                            </div>
                            <h6 data-name="product_name" class="product-name">
                              <a href="{{ route('user.products_detail', $newProduct->id) }}"
                                title="Casual Shirt With Ruffle Hem">{{ $newProduct->name }}
                              </a>
                            </h6>
                            <span class="price"><span class="amount"><span class="currencySymbol"></span>{{ format_number_to_money($newProduct->price_sell) }} VNĐ</span>
                            </span>
                          </div>
                          <div class="button_group">
                            <a href="{{ route('user.products_detail', $newProduct->id) }}" class="btn btn-primary" type="button">Xem Chi Tiết</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- =====  CONTAINER END  ===== -->
    @vite(['resources/client/css/home.css'])
@endsection
    