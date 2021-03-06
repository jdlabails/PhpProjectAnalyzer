$('document').ready(function () {
    $(".help").popover({placement: 'left', html: true});
});

function lancerUneAnalyse(one) {
   
    $.ajax({
        url: "analyser.php",
        data: {
            'one' : one
        },
        method: 'post'
    }).done(function (data) {
        $('#formLanceur').hide();
        $('#refreshLanceur').show();
        setTimeout(refreshLanceur, 3000);
    });

    return false;
}

function lancerAnalyse() {
   
    $.ajax({
        url: "analyser.php",
        data: {
            genDoc: document.getElementById('genDoc').checked * 1,
            genCC: document.getElementById('genCC').checked * 1
        },
        method: 'post'
    }).done(function (data) {
        $('#formLanceur').hide();
        $('#refreshLanceur').show();
        setTimeout(refreshLanceur, 3000);
    });

    return false;
}

function refreshLanceur() {
    $('#formLanceur').hide();
    $('#refreshLanceur').show();
    $.ajax({
        url: "analyser.php?statut=1"
    }).done(function (data) {
        if (data == 'ok') {
            $('#rechargePage').show();
            $('#refreshLanceur').hide();
        } else {
            setTimeout(refreshLanceur, 3000);
        }
    });
}
