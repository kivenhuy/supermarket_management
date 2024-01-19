@extends('layouts.app')
@section('content')

    <!-- Cart Details -->
    <section class="mb-4" id="cart-summary">
        @include('cart.partials.cart_details', ['carts' => $carts])
    </section>

@endsection
@section('modal')
    {{-- New Address Modal --}}
    
@endsection
@section('script')

    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            // removeFromCart(key);
        }

        
    </script>
@endsection
