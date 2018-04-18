$(function () {

    var listmenuheader = $("#listmenuheader");
    listmenuheader.hide();

    $(".menu").on('click', function() {
        listmenuheader.toggle(200);

    });

    var unavailableDates = ["1/5/2018", "1/11/2018", "25/12/2018"];

    function unavailable(date) {
        dmy = date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();
        if ($.inArray(dmy, unavailableDates) < 0) {
            return [true,"",""];
        }else {
            return [false,"",""];
        }
    }


    $('.datepicker').datepicker({
                altField: "#datepicker",
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem.',
                dateFormat: 'dd/mm/yy',
                minDate: 'today',
                beforeShowDay: unavailable




    });


    $('#louvre_louvrebundle_booking_tickets_discount').attr('type','checkbox');
        $('#louvre_louvrebundle_booking_tickets_discount').checkboxradio();


});