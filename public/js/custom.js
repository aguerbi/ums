/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Javascript to enable link to tab
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
}

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})


//
$(function () {
    $('button').click(function () {
        document.querySelector('.envoyer').innerHTML = 'En cours...';
        this.form.submit();
        this.disabled = true;
    });
}
);
$('input[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
});
// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable, #dataTable1').DataTable({
        "language": {
            "lengthMenu": "Affichage _MENU_ par page",
            "zeroRecords": "Aucun enregistrement trouvé",
            "info": "Affichage _PAGE_ de _PAGES_",
            "infoEmpty": "Aucun enregistrement disponible",
            "infoFiltered": "(filtré de _MAX_ enregistrements)",
            "sSearch": "",
            "sSearchPlaceholder": "Recherche...",
            "paginate": {
                "sNext": "Suivant",
                "sPrevious": "Précédent",
            }
        }
    });

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(function () {
    $('.datetimepicker5').datetimepicker();
});