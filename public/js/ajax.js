$(document).ready(function(){
    $modal = $('.modal');
    $modal.find('form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "{{ path('reservation_accepted', { 'id': annonce.id}) }}",
            data: $(this).serialize(),
            success: function(message){
                $("#reserve").replaceWith(message)
                $("#myModal").modal('hide');
                $('#show_image').attr('src', "{{ asset('img/reserve.png') }}")
            },
            error: function(){
                alert("Une erreur s'est produite, veuillez réessayer");
            }
        });
    })
}); 