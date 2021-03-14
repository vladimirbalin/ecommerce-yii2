$(document).on('click', '.add-to-cart-btn', function (e) {
    e.preventDefault();
    const $this = $(e.target);
    const $url = $this.attr('href');
    const id = $this.attr('data-key');
    const quantitySum = $('#quantity-sum');
    console.log(id)
    $.ajax($url, {
        method: 'post',
        data: {id},
        success: function ($res) {
            quantitySum.text(parseInt(quantitySum.text() || 0) + 1);
        },
        error: function ($res) {
        }
    })
})