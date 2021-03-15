$(function () {
    const $addBtn = $('.add-to-cart-btn');
    const $deleteBtn = $('.delete-from-cart-btn');
    $addBtn.click(function (e) {
        e.preventDefault();
        const $this = $(e.target);
        const $url = $this.attr('href');
        const id = $this.attr('data-key');
        const quantitySum = $('#quantity-sum');
        console.log($url)
        $.ajax($url, {
            method: 'post',
            data: {id},
            success: function ($res) {
                console.log($res);
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
        console.log($url, id);
        $.ajax($url, {
            method: 'post',
            data: {id},
            success(res){
                console.log(res)
            },
            error(res){
                console.log(res)
            }
        })
    })
});