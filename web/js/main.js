$(document).ready(function() {
    $('#search-form').on('submit', function(e) {

        e.preventDefault();

        var form = $(this);
        var urlAction = 'index.php?r=site/index';

        function showNotification(resultat, statusClass) {
            $('#notification-banner')
                .removeClass()
                .addClass('alert alert-' + statusClass + ' alert-dismissible fade show')
                .html(resultat);
        }


        $.ajax({
            url: urlAction,
            type: 'GET',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {


                $('#hero-default-content').fadeOut(200, function() {
                    $('#hero-ajax-results').html(response.content).fadeIn(200);
                });
                showNotification(response.resultat, response.statusClass)

            },
            error: function() {
                $resultat = "villes n'existes pas !";
                $statusClass = 'danger';
                showNotification($resultat, $statusClass)
            }
        });
    });


    $(document).on('click', '.trip-card', function(e) {

        if ($(e.target).closest('.btn-book, a').length) {
            return;
        }

        if ($(this).hasClass('full-trip')) {
            return;
        }

        $(this).toggleClass('active');
    });
});


