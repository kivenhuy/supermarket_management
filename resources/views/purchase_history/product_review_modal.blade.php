<div class="modal-header">
    <h5 class="modal-title h6">Review</h5>
    <button type="button" class="close" data-dismiss="modal">
    </button>
</div>

@if($review == null)
    <!-- Add new review -->
    <form action="{{ route('purchase_history.review.store') }}" method="POST" >
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="modal-body">
            <div class="form-group">
                <label class="opacity-60">Product</label>
                <p>{{ $product->name }}</p>
            </div>
            <!-- Rating -->
            <div class="form-group">
                <label class="opacity-60">Rating</label>
                <div class="rating rating-input">
                    <label>
                        <input type="radio" name="rating" value="1" required>
                        <i class="fa fa-star"></i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="2">
                        <i class="fa fa-star"></i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="3">
                        <i class="fa fa-star"></i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="4">
                        <i class="fa fa-star"></i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="5">
                        <i class="fa fa-star"></i>
                    </label>
                </div>
            </div>
            <!-- Comment -->
            <div class="form-group">
                <label class="opacity-60">Comment</label>
                <textarea class="form-control rounded-0" rows="4" name="comment" placeholder="Your review" required></textarea>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-sm btn-primary rounded-0">Submit Review</button>
        </div>
    </form>
@else
    <!-- Review -->
    <div class="modal-body">
            <!-- Rating -->
            <div class="form-group">
                <label class="opacity-60">Rating</label>
                <p class="rating rating-sm">
                    @for ($i=0; $i < $review->rating; $i++)
                        <i class="fa fa-star active"></i>
                    @endfor
                    @for ($i=0; $i < 5-$review->rating; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                </p>
            </div>
            <!-- Comment -->
            <div class="form-group">
                <label class="opacity-60">Comment</label>
                <p class="comment-text">
                    {{ $review->comment }}
                </p>
            </div>
            <!-- Review Images -->
        </div>
    </div>
@endif