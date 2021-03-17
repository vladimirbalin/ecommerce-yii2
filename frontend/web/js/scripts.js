$(function () {
    const $addBtn = $('.add-to-cart-btn');
    const $deleteBtn = $('.delete-from-cart-btn');
    const $increaseBtn = $('.increase-btn');
    const $decreaseBtn = $('.decrease-btn');
    const quantitySum = $('#quantity-sum');
    const $inputProdQuantity = $('.input-prod-quantity');
    const maxQuantity = 1000;

    $addBtn.click(function (e) {
        e.preventDefault();
        const $this = $(e.target);
        const $url = $this.attr('href');
        const id = $this.attr('data-key');

        $.ajax($url, {
            method: 'post',
            data: {id},
            success: function ($res) {
                quantitySum.text(parseInt(quantitySum.text() || 0) + 1);
            },
            error: function ($res) {
                console.log($res)
            }
        })
    })
    $deleteBtn.click(function (e) {
        e.preventDefault();
        const $this = $(e.target);
        const $url = $this.attr('href');
        const id = $this.attr('data-key');
        $.ajax($url, {
            method: 'post',
            data: {id},
            success(res) {
                console.log(res)
            },
            error(res) {
                console.log(res)
            }
        })
    })

    function changeQuantity(btn) {
        btn.click(function (e) {
            const $this = $(e.target);
            const quantity = parseInt($this.siblings('input[type=number]').val());
            if (btn === $increaseBtn) {
                if (!isNaN(quantity && quantity < maxQuantity)) {
                    $this.siblings('input[type=number]').val(quantity + 1);
                    $this.siblings('input[type=number]').change();
                }
            } else if (btn === $decreaseBtn) {
                if (!isNaN(quantity) && quantity > 1) {
                    $this.siblings('input[type=number]').val(quantity - 1);
                    $this.siblings('input[type=number]').change();
                }
            }
        })


    }

    $decreaseBtn.click(changeQuantity($decreaseBtn));
    $increaseBtn.click(changeQuantity($increaseBtn));
    $inputProdQuantity.change(function (e) {
        const $this = $(e.target);
        const $td = $($this.closest('td'));
        const $tr = $($this.closest('tr'));
        $.ajax('/cart/change-quantity', {
            method: 'post',
            data: {quantity: $this.val(), id: $tr.attr('data-key')},
            success(res) {
                $td.next('td').text(res.totalPrice);
                quantitySum.text(res.cartQuantity);
            }
        })
    })

});