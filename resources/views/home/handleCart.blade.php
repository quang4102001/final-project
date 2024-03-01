{{-- product detail --}}
<script>
    $(document).ready(function() {
        $('#product-detail .image-btn').each(function() {
            $(this).click(function() {
                let src = $(this).attr('src')
                $('.image-view').attr('src', src)
            })
        })
        $('#product-detail #button-except').click(function() {
            let currentVal = $('#input-qty').val()
            $('#input-qty').val(parseInt(currentVal) - 1)
            if ($('#input-qty').val() < 1) {
                $('#input-qty').val(1)
            }
        })
        $('#product-detail #button-add').click(function() {
            let currentVal = $('#input-qty').val()
            $('#input-qty').val(parseInt(currentVal) + 1)
        })
        $('#product-detail #input-qty').change(function() {
            if ($(this).val() < 1) {
                $(this).val(1)
            }
        })
        $('#product-detail #add-to-cart').click(function() {
            const id = $(this).attr('data-id')
            const name = $('#product-detail #product-name').html()
            const img = $('#product-detail .image-btn').first().attr('src')
            const price = $('#product-detail #product-price').attr('data-price')
            const colorId = $('.input-color:checked').val()
            const colorName = $('.input-color:checked').attr('data-color-name')
            const color = {
                id: colorId,
                name: colorName
            }
            const qty = $('#input-qty').val()

            if (colorId) {
                for (let i = 0; i < qty; i++) {
                    addToCart(id, name, img, price, color)
                }
            } else {
                Toastify({
                    text: "Choose color.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #dc3545, #dc8890)",
                    },
                }).showToast();
            }
        })
    })
</script>
