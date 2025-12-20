$(document).ready(function() {
    function showNotification(resultat, statusClass, duration = 3000) {
        const $banner = $('#notification-banner');

        $banner
            .removeClass()
            .addClass('alert alert-' + statusClass + ' alert-dismissible fade show')
            .html(resultat)
            .fadeIn(200);

        setTimeout(function () {
            $banner.fadeOut(300, function () {
                $banner.removeClass().html('');
            });
        }, duration);
    }

    $('#search-form').on('submit', function(e) {

        e.preventDefault();

        var form = $(this);
        var urlActionIndex = 'index.php?r=site/index';

        $('body').css('cursor', 'wait');



        $.ajax({
            url: urlActionIndex,
            type: 'GET',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {


                $('#hero-default-content').fadeOut(200, function() {
                    $('#villes').fadeOut(200);
                    $('#concept').fadeOut(200);
                    $('#hero-ajax-results').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                });
                const $container = $('#hero-ajax-results');
                if ($container.length) {
                    $('html, body').animate({ scrollTop: $('body').offset().top}, 300);
                }

                showNotification(response.resultat, response.statusClass)

            },
            error: function() {
                $resultat = "Trajet n'existes pas !";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        });


    });

    $(document).on('click', '.js-auth-link', function(e) {

        e.preventDefault();

        var url = $(this).attr('href');

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#accueil, #villes, #concept, #hero-ajax-results').fadeOut(200);

                setTimeout(function() {
                    $('#auth-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                }, 200);
            },
            error: function() {
                $resultat = "Impossible de charger la page";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        })
    });

    $(document).on('click', '.js-modify-link', function(e) {
        e.preventDefault();

        const $searchBar = $('.search-bar');
        $searchBar.addClass('is-active');

        // Focus + sélection du champ "depart"
        const $depart = $('#search-form input[name="depart"]');
        if ($depart.length) {
            // Scroll vers la barre de recherche pour que l'utilisateur la voie
            const $container = $('.search-container-wrapper');
            if ($container.length) {
                $('html, body').animate({ scrollTop: $container.offset().top - 200 }, 300);
            }

            // Donner le focus et sélectionner le texte
            setTimeout(function () {
                $depart.trigger('focus');
                // Certains navigateurs nécessitent un léger délai pour select()
                setTimeout(function () { $depart.select(); }, 10);
            }, 220);

            // Retirer l'état "actif" quand l'utilisateur quitte le champ ou soumet
            $depart.one('blur', function () { $searchBar.removeClass('is-active'); });
            $('#search-form').one('submit', function () { $searchBar.removeClass('is-active'); });
        }
    })

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


