function gitPull()
{
    const repository = $('#active-repository').val();

    $.ajax({
        type: 'POST',
        url: 'ajax/overview.php',
        data: '&m=gitPull&repository=' + repository,
        success: function (resultData) {
            loadPage('overview');
            toast('Git: Pull', 'The \'' + repository + '\' repository has been pulled.', 'info');
        }
    });
}
// ---------------------------------------------------------------------------------------------
