function gitPull()
{
    const repository = $('#active-repository').val();
    $('#page-content').html('<i class="fas fa-cog fa-spin"></i> Gathering all the data, crunching all the numbers...');

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
