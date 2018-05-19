$(function () {



    $('input').addClass('form-control');


    $('#louvre_louvrebundle_booking_tickets_0_country').val("FR");
    $($('#louvre_louvrebundle_booking_tickets label')[0]).text('Ticket n°1');



    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#louvre_louvrebundle_booking_tickets');
    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length / 5;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
        addTicket($container);



        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un
    if (index == 0) {
        $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Ticket n°1')
            .replace(/__name__/g,        0)
            .replace()
        ;
        addTicket($container);

    } else {
        // S'il existe déjà des tickets, on ajoute un lien de suppression pour chacun d'entre eux
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }
    // La fonction qui ajoute un formulaire TicketType
    function addTicket($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Ticket n° ' + (index + 1))
            .replace(/__name__/g,        index)
            .replace('<input', '<input class="form-control"')
        ;
        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);
        // On ajoute au prototype un lien pour pouvoir supprimer le ticket
        addDeleteLink($prototype);
        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);
        $container.attr('id', 'booking_tickets');
        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }
    // La fonction qui ajoute un lien de suppression d'un ticket
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<br><a href="#" class="btn btn-danger"><i class="material-icons">-</i></a>');
        // Ajout du lien
        $prototype.append($deleteLink);
        // Ajout du listener sur le clic du lien pour effectivement supprimer le lien
        $deleteLink.click(function (e) {
            $prototype.remove();
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }








});






