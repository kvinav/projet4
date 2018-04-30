$(function () {

    /* MENU */

    var listmenuheader = $("#listmenuheader");
    listmenuheader.hide();

    $(".menu").on('click', function() {
        listmenuheader.toggle(200);

    });

    /* ORDER FORM */

    /* Visit date configuration */

    var currentdate = new Date();
    var currentmonth = currentdate.getMonth()+1;
    if(currentmonth<10){
        currentmonth='0'+currentmonth
    }
    var currentday = currentdate.getDate();
    if(currentday<10){
        currentday='0'+currentday
    }
    var currentyear = currentdate.getFullYear();

    var today = currentday+'/'+currentmonth+'/'+currentyear;
    var currenttime = new Date();
    var hours = currenttime.getHours();



    var pickeddate = $('#louvre_louvrebundle_booking_dateVisit').val();




    $('.ticketinput div:nth-child(3)').css("font-size", "20px");
    $('.datevisitlabel').css('display', 'none');
    $('.emaillabel').css('display', 'none');
    $('#form button').addClass('btngoto');

    $($('#louvre_louvrebundle_booking_tickets_0 label')[0]).css("display", "none");
    $($('#louvre_louvrebundle_booking_tickets_0 label')[1]).css("display", "none");
    $($('#louvre_louvrebundle_booking_tickets_0 label')[3]).css("display", "none");


    $($('#form_tickets label')[0]).css("display", "none");
    $('#louvre_louvrebundle_booking_dateVisit').attr("placeholder", "Date de la visite");
    $('#louvre_louvrebundle_booking_email').attr("placeholder", "Email");


    $('#louvre_louvrebundle_booking_tickets_0_name').attr("placeholder", "Nom");
    $('#louvre_louvrebundle_booking_tickets_0_surname').attr("placeholder", "Prénom");
    $('#louvre_louvrebundle_booking_tickets_0_dateOfBirth').attr("placeholder", "Date de naissance");


    $('#louvre_louvrebundle_booking_tickets_0_country').val("FR");



    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#louvre_louvrebundle_booking_tickets');
    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;
    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
        addTicket($container);



        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un
    if (index == 0) {
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
            .replace(/__name__label__/g, 'Ticket n° ' + (index+1))
            .replace(/__name__/g,        index)
        ;
        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);
        // On ajoute au prototype un lien pour pouvoir supprimer le ticket
        addDeleteLink($prototype);
        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);
        $container.attr('id', 'form_tickets');
        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }
    // La fonction qui ajoute un lien de suppression d'un ticket
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btngoto">Supprimer</a>');
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






