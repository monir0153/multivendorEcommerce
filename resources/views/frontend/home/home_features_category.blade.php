@php
    $categories = App\Models\Category::orderBy('category_name', 'ASC')->get();
@endphp
<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Featured Categories</h3>

            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
        </div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">
                @foreach ( $categories as $category )
                    <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="shop-grid-right.html"><img src="{{ asset($category->category_image) }}" alt="" /></a>
                        </figure>
                        <h6><a href="shop-grid-right.html">{{$category->category_name}}</a></h6>

                        @php
                            $product = App\Models\Product::where('category_id', $category->id)->get();
                        @endphp
                        <span>{{count($product)}} items</span>
                    </div>
                @endforeach

                {{-- <div class="card-2 bg-10 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <figure class="img-hover-scale overflow-hidden">
                        <a href="shop-grid-right.html"><img src="{{ asset('frontend/assets/imgs/shop/cat-12.pn') }}g" alt="" /></a>
                    </figure>
                    <h6><a href="shop-grid-right.html">Oganic Kiwi</a></h6>
                    <span>28 items</span>
                </div>
                <div class="card-2 bg-11 wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                    <figure class="img-hover-scale overflow-hidden">
                        <a href="shop-grid-right.html"><img src="{{ asset('frontend/assets/imgs/shop/cat-11.png') }}" alt="" /></a>
                    </figure>
                    <h6><a href="shop-grid-right.html">Peach</a></h6>
                    <span>14 items</span>
                </div>
                 --}}
            </div>
        </div>
    </div>
</section>
