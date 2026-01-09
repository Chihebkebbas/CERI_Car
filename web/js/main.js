$(document).ready(function () {
    /**
     * Affiche une notification temporaire en haut de la page.
     * 
     * @param {string} resultat - Message à afficher.
     * @param {string} statusClass - Classe CSS pour le style (success, danger, warning, etc.).
     * @param {number} duration - Durée d'affichage en ms (défaut: 3000).
     */
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

    /**
     * Charge automatiquement une section basée sur le hash de l'URL
     * Utilisé quand on redirige depuis une autre page
     */
    function loadFromHash() {
        const hash = window.location.hash;

        if (hash === '#reservations') {
            // Déclencher le clic sur le lien réservations
            setTimeout(function () {
                $('.reservation-ajax-link').first().trigger('click');
            }, 300);
        } else if (hash === '#voyages') {
            // Déclencher le clic sur le lien voyages
            setTimeout(function () {
                $('.voyage-ajax-link').first().trigger('click');
            }, 300);
        }
    }

    // Charger la section au démarrage si un hash est présent
    loadFromHash();

    /**
     * Gestion de la soumission du formulaire de recherche de voyages.
     * Effectue une requête AJAX et met à jour les résultats sans recharger la page.
     */
    $('#search-form').on('submit', function (e) {

        e.preventDefault();

        var form = $(this);
        var urlActionIndex = 'index.php?r=site/index';

        $('body').css('cursor', 'wait');



        $.ajax({
            url: urlActionIndex,
            type: 'GET',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {


                $('#hero-default-content').fadeOut(200, function () {
                    $('#villes').fadeOut(200);
                    $('#concept').fadeOut(200);
                    $('#reservation-ajax-container').fadeOut(200);
                    $('#voyage-ajax-container').fadeOut(200);
                    $('#profile-ajax-container').fadeOut(200);
                    $('#create-ajax-container').fadeOut(200);
                    $('#hero-ajax-results').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                });
                const $container = $('#hero-ajax-results');
                if ($container.length) {
                    $('html, body').animate({ scrollTop: $('body').offset().top }, 300);
                }

                showNotification(response.resultat, response.statusClass);
                setTimeout(function () {
                    showNotification(response.resultatCorrespondance, response.statusCorrespondance)
                }, 4000)


            },
            error: function () {
                $resultat = "Trajet n'existes pas !";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        });


    });

    /**
     * Chargement AJAX des pages d'authentification (connexion/inscription).
     */
    $(document).on('click', '.js-auth-link', function (e) {

        e.preventDefault();

        var url = $(this).attr('href');

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#accueil, #villes, #concept, #accueil, #hero-ajax-results, #create-ajax-container').fadeOut(200);

                setTimeout(function () {
                    $('#auth-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                }, 200);
            },
            error: function () {
                $resultat = "Impossible de charger la page";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        })
    });

    /**
     * Permet de modifier la recherche actuelle en remettant le focus sur le champ départ.
     */
    $(document).on('click', '.js-modify-link', function (e) {
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

    /**
     * Soumission du formulaire d'inscription via AJAX.
     */
    $(document).on('submit', '.signup-form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',

            success: function (response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                } else {
                    var errorMsg = "Erreur lors de l'inscription";
                    showNotification(errorMsg, 'danger');
                }
            },
            error: function () {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    /**
     * Soumission du formulaire de connexion via AJAX.
     */
    $(document).on('submit', '.login-form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');
        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',

            success: function (response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                        $('body').css('cursor', 'default');
                    }
                } else {
                    var errorMsg = "Erreur lors de la connexion";
                    showNotification(errorMsg, 'danger');
                }
            },
            error: function () {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    /**
     * Chargement de la liste des réservations de l'utilisateur via AJAX.
     */
    $(document).on('click', '.reservation-ajax-link', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#hero-default-content, #villes, #concept, #hero-ajax-results, #voyage-ajax-container, #profile-ajax-container, #create-ajax-container').fadeOut(200);

                setTimeout(function () {
                    $('#reservation-ajax-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');

                    // Scroll vers le haut de la page
                    $('html, body').animate({ scrollTop: 0 }, 300);
                }, 200);

                showNotification(response.message, response.statusClass);
            },
            error: function () {
                $resultat = "Impossible de charger la page";
                $statusClass = 'danger';
                $('body').css('cursor', 'default');
                showNotification($resultat, $statusClass)
            }
        })

    })



    /**
     * Effectue une réservation pour un voyage (direct ou avec correspondance).
     */
    $(document).on('click', '.btn-book-ajax', function (e) {
        e.preventDefault();
        const button = $(this);

        // On récupère les IDs (direct ou correspondance)
        const voyageId = button.data('id');
        const voyageId1 = button.data('id1');
        const voyageId2 = button.data('id2');
        const places = button.data('places');

        const url = 'index.php?r=site/reservation';
        $('body').css('cursor', 'wait');

        // On prépare les données à envoyer
        let postData = {
            places: places,
            _csrf: yii.getCsrfToken()
        };

        if (voyageId) {
            postData.voyageId = voyageId;
        } else {
            postData.voyageId1 = voyageId1;
            postData.voyageId2 = voyageId2;
        }

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: postData,

            success: function (response) {
                if (response.success === true) {
                    showNotification(response.message, "success");
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                } else {
                    showNotification(response.message, "danger");
                    if (response.content) {
                        $('#accueil, #hero-ajax-results, #create-ajax-container').fadeOut(200);
                        $('#auth-container').html(response.content).fadeIn(200);
                    }
                    $('body').css('cursor', 'default');

                }

                $('body').css('cursor', 'default');
            },

            error: function () {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })

    })

    /**
     * Annule une réservation existante via AJAX.
     */
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

            success: function (response) {
                showNotification(response.message, response.statusClass);

                if (response.redirect) {
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                }
                $('body').css('cursor', 'default');
            },

            error: function () {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })

    /**
     * Chargement des voyages proposés par le conducteur via AJAX.
     */
    $(document).on('click', '.voyage-ajax-link', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        // Vérifier si on est sur la page d'accueil (si le conteneur existe)
        if ($('#voyage-ajax-container').length === 0) {
            // Si on n'est pas sur l'accueil, rediriger vers l'accueil avec le hash
            window.location.href = 'index.php?r=site/index#voyages';
            return;
        }

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (!response.success) {
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                }

                showNotification(response.message, response.statusClass);

                if (response.success) {
                    $('#reservation-ajax-container, #hero-default-content, #villes, #concept, #hero-ajax-results, #create-ajax-container, #profile-ajax-container, #auth-container').fadeOut(200);
                    setTimeout(function () {
                        $('#voyage-ajax-container').html(response.content).fadeIn(200);
                        $('body').css('cursor', 'default');

                        // Scroll vers le haut de la page
                        $('html, body').animate({ scrollTop: 0 }, 300);
                    }, 200);
                }

            },
            error: function () {
                showNotification("Une erreur technique est survenue !", "danger");
            }
        })
    })

    /**
     * Chargement du formulaire de profil via AJAX.
     */
    $(document).on('click', '.profile-ajax-link', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#reservation-ajax-container, #accueil, #villes, #concept, #hero-ajax-results, #voyage-ajax-container, #create-ajax-container').fadeOut(200);
                setTimeout(function () {
                    $('#profile-ajax-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                }, 200);
            },
            error: function () {
                showNotification("Une erreur technique est survenue !", "danger");
                $('body').css('cursor', 'default');
            }
        })

    })

    /**
     * Mise à jour du profil utilisateur via AJAX.
     */
    $(document).on('submit', '#profile-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = 'index.php?r=site/profile';
        var nouveauPseudo = '@' + form.find('input[name="pseudo"]').val();
        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),

            success: function (response) {
                $('body').css('cursor', 'default');

                if (response.success) {
                    showNotification(response.message, 'success', 10000);
                    if (nouveauPseudo) {
                        $('#header-pseudo').text(nouveauPseudo);
                    }
                    if (response.content) {
                        $('#profile-ajax-container').html(response.content);
                    }
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                $('body').css('cursor', 'default');
                showNotification("Une erreur technique est survenue", "danger");
            }
        });
    })

    /**
     * Chargement du formulaire de création de voyage via AJAX.
     */
    $(document).on('click', '.create-ajax-link', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('body').css('cursor', 'wait');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#reservation-ajax-container, #accueil, #villes, #concept, #hero-ajax-results, #voyage-ajax-container, #profile-ajax-container').fadeOut(200);
                setTimeout(function () {
                    $('#create-ajax-container').html(response.content).fadeIn(200);
                    $('body').css('cursor', 'default');
                }, 200);
            }
        })
    })

    /**
     * Soumission du formulaire de création de voyage via AJAX.
     */
    $(document).on('submit', '#create-trip-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = 'index.php?r=site/create';

        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),

            success: function (response) {
                $('body').css('cursor', 'default');

                if (response.success) {
                    showNotification(response.message, 'success');

                    // Si succès, on redirige vers l'accueil ou on vide le formulaire
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    // Affichage de l'erreur
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                $('body').css('cursor', 'default');
                showNotification("Erreur technique lors de la création du voyage.", "danger");
            }
        });
    });

    /**
     * Annulation d'un voyage proposé via AJAX.
     */
    $(document).on('click', '.cancel-voyage-ajax', function (e) {
        e.preventDefault();
        const button = $(this);
        const voyageId = button.data('id');
        var url = 'index.php?r=site/voyage';
        $('body').css('cursor', 'wait');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                voyageId: voyageId,
                _csrf: yii.getCsrfToken()
            },

            success: function (response) {
                showNotification(response.message, response.statusClass);

                if (response.redirect) {
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                }
                $('body').css('cursor', 'default');
            },

            error: function () {
                showNotification("Une erreur technique est survenue", "danger");
            }
        })
    })


    /**
     * Force le rechargement de la page lors du clic sur le logo ou certains liens d'ancre
     * si un contenu AJAX est actuellement affiché.
     */
    $(document).on('click', 'a[href*="#villes"], a[href*="#concept"], .logo', function (e) {

        if ($('#hero-ajax-results').is(':visible') || $('#auth-container').is(':visible') || $('#profile-ajax-container').is(':visible')) {

            window.location.href = $(this).attr('href');
            window.location.reload();
        }
    });



    /**
     * Gère l'expansion des cartes de voyage au clic pour afficher plus de détails.
     */
    $(document).on('click', '.trip-card', function (e) {

        if ($(e.target).closest('.btn-book, a, .btn-cancel').length) {
            return;
        }

        if ($(this).hasClass('full-trip')) {
            return;
        }

        $(this).toggleClass('active');
    });
});


