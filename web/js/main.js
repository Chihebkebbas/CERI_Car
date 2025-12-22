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
                    $('#reservation-ajax-container').fadeOut(200);
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

    $(document).on('submit', '.signup-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');

        $.ajax({
            url : url,
            type : 'POST',
            data: $form.serialize(),
            dataType: 'json',

            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                } else {
                    var errorMsg = "Erreur lors de l'inscription";
                    showNotification(errorMsg, 'danger');
                }
            },
            error: function() {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    $(document).on('submit', '.login-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');
        $('body').css('cursor', 'wait');

        $.ajax({
            url : url,
            type : 'POST',
            data: $form.serialize(),
            dataType: 'json',

            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                        $('body').css('cursor', 'default');
                    }
                } else {
                    var errorMsg = "Erreur lors de la connexion";
                    showNotification(errorMsg, 'danger');
                }
            },
            error: function() {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    $(document).on('click', '.reservation-ajax-link', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#hero-default-content, #villes, #concept, #hero-ajax-results').fadeOut(200);

                setTimeout(function() {
                    $('#reservation-ajax-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                }, 200);

                showNotification(response.message, response.statusClass);
            },
            error: function() {
                $resultat = "Impossible de charger la page";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        })

    })



    $(document).on('click', '.btn-book-ajax', function (e) {
        e.preventDefault();
        const button = $(this);
        const voyageId = button.data('id');
        const places = button.data('places');
        const price = button.data('price');
        var url = 'index.php?r=site/reservation';

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                voyageId: voyageId,
                places: places,
                price: price,
                _csrf: yii.getCsrfToken()
            },

            success: function(response) {
                showNotification(response.message, "success");
                if (response.redirect) {
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 2000);

                }
                $('body').css('cursor', 'default');
            },

            error: function() {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })

    })

    $(document).on('click', '.cancel-reservation-ajax', function (e) {
        e.preventDefault();
        const button = $(this);
        const reservationId = button.data('id');
        var url = 'index.php?r=site/reservation';
        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                reservationId: reservationId,
                _csrf: yii.getCsrfToken()
            },

            success: function(response) {
                showNotification(response.message, response.statusClass);

                if (response.redirect) {
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 2000);
                }
                $('body').css('cursor', 'default');
            },

            error: function() {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    $(document).on('click', '.trip-card', function(e) {

        if ($(e.target).closest('.btn-book, a, .btn-cancel').length) {
            return;
        }

        if ($(this).hasClass('full-trip')) {
            return;
        }

        $(this).toggleClass('active');
    });
});


