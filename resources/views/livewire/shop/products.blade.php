<div>
    @if($brand->brand_type == \App\Enums\Status::PRODUCT)
        @include('components.shop.product-owner')
    @else
        @include('components.shop.service-provider')
    @endif
</div>
