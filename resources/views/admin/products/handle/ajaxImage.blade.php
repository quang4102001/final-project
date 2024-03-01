<script>
    $(document).ready(function() {
            $('#input-upload-image').change(function(e) {
                if (e.target.files.length > 0) {
                    let formData = new FormData();
                    formData.append('image', e.target.files[0]);

                    $.ajax({
                        url: "{{ route('images.upload') }}",
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            $('#image-list-box').prepend(
                                '<label class="col mb-5 relative">' +
                                '<input class="position-absolute" type="checkbox" name="images[]" value="' +
                                res.id + '" checked/>' +
                                '<img src="' + res.path +
                                '" alt="Image" style="width: 100px;">' +
                                '</label>'
                            )
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
                }
            })
        });
</script>