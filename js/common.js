$(document).ready(function () {

});
// -------------------------------------------------------------------------------------------
function loadPage(page)
{
    const repository = $('#active-repository').val();
    if (repository == '0') {
        toast('Active Repository', 'Please select a repository before trying to view information', 'error');
        return;
    }

    $('#page-content').html('<i class="fas fa-cog fa-spin"></i> Gathering all the data, crunching all the numbers...');

    $.ajax({
        type: 'POST',
        url: 'ajax/' + page + '.php',
        data: '&m=init&repository=' + repository,
        success: function (resultData) {
            $('#page-content').html(resultData);
        }
    });
}
// ---------------------------------------------------------------------------------------------
function cloneRepository()
{
    const url = $('#clone-url').val();
    const folder = $('#clone-folder').val();

    if (!url) {
        toast('Clone Repository', 'URL is required', 'error');
        return;
    }
    if (!folder) {
        toast('Clone Repository', 'Folder is required', 'error');
        return;
    }

    $('#clone-result').html('Attempting to clone...');

    $.ajax({
        type: 'POST',
        url: 'ajax/common.php',
        data: '&m=cloneRepository&url=' + url + '&folder=' + folder,
        success: function (resultData) {
            $('#clone-result').html(resultData);
        }
    });
}
// ---------------------------------------------------------------------------------------------
function addNewRepository()
{
    const repository = $('#active-repository').val();

    $.ajax({
        type: 'POST',
        url: 'ajax/common.php',
        data: '&m=addNewRepository&repository=' + repository,
        success: function (resultData) {
            $('#page-content').html(resultData);
        }
    });
}
// ---------------------------------------------------------------------------------------------
function checkoutBranch()
{
    const repository    = $('#active-repository').val();
    const branch        = $('#active-branch').val();

    $.ajax({
        type: 'POST',
        url: 'ajax/common.php',
        data: '&m=checkoutBranch&repository=' + repository + '&branch=' + branch,
        success: function (resultData) {
            $('#page-content').html('Select a repository and a page to view<br><br>');
            loadRepositoryBranches();
        }
    });
}
// ---------------------------------------------------------------------------------------------
function loadRepositoryBranches()
{
    const repository = $('#active-repository').val();

    $.ajax({
        type: 'POST',
        url: 'ajax/common.php',
        data: '&m=loadRepositoryBranches&repository=' + repository,
        success: function (resultData) {
            $('#active-branch').html(resultData).show();
            $('#page-content').html('Select a repository and a page to view<br><br>');
        }
    });
}
// ---------------------------------------------------------------------------------------------
function toast(title, message, type)
{
    const uniqueId = Date.now() + Math.floor(Math.random() * 1000);

    let toast  = '';
    let border = 'primary';

    if (type == 'error') {
        border = 'danger';
    }
    if (type == 'success') {
        border = 'success';
    }

    toast += '<div id="toast-' + uniqueId + '" class="toast border-' + border + '" data-autohide="false">';
    toast += '  <div class="toast-header" style="background-color: #191c24;">';
    toast += '      <i class="far fa-bell text-muted me-2"></i>';
    toast += '      <strong class="me-auto">' + title + '</strong>';
    toast += '      <small>' + type + '</small>';
    toast += '      <button type="button" class="btn-close" onclick="$(\'#toast-' + uniqueId + '\').remove();"></button>';
    toast += '  </div>';
    toast += '  <div class="toast-body" style="background-color: #343a40;">' + message + '</div>';
    toast += '</div>';

    $('.toast-container').append(toast);
    $('#toast-' + uniqueId).toast('show');

    setTimeout(function () {
        $('#toast-' + uniqueId).remove();
    }, 10000);

}
// -------------------------------------------------------------------------------------------
function dialogOpen(p)
{
    const id     = p.id;
    const title  = p.title ? p.title : '&nbsp;';
    const body   = p.body ? p.body : '&nbsp;';
    const footer = p.footer ? p.footer : '&nbsp;';
    const close  = typeof p.close === 'undefined' ? true : p.close;
    // -- sm, lg, xl
    const size     = p.size ? p.size : '';
    const escape   = typeof p.escape === 'undefined' ? false : p.escape;
    const minimize = typeof p.minimize === 'undefined' ? false : p.minimize;

    if (typeof id === 'undefined') {
        console.log('Error: Called dialogOpen with no id parameter');
        return;
    }

    // -- CLONE IT
    $('#dialog-modal').clone().appendTo('#dialog-modal-container').prop('id', id);

    // -- USE THE CLONE
    $('#' + id).modal({
        keyboard: false,
        backdrop: 'static'
    });

    if (escape) {
        $('#' + id).attr('data-escape-close', 'true');
    }

    $('#' + id + ' .modal-title').html(title);
    $('#' + id + ' .modal-body').html(body);
    $('#' + id + ' .modal-footer').html(footer);

    if (!close) {
        $('#' + id + ' .btn-close').hide();

        $('#' + id + ' .modal-header').dblclick(function () {
            $('#' + id + ' .btn-close').show();
        });
    }

    if (minimize) {
        const closeBtn = $('#' + id + ' .btn-close').clone();

        $('#' + id + ' .btn-close').remove();
        $('#' + id + ' .modal-header').append('<div style="float: right;" class="dialog-btn-container"></div>');
        $('#' + id + ' .modal-header .dialog-btn-container').append('<i onclick="$(\'#' + id + '\').modal(\'hide\'); $(\'#' + id + '-minimized\').show();" class="fa-solid fa-window-minimize" style="cursor: pointer;"></i>').append(closeBtn);

        let minimizeDiv = '<div id="' + id + '-minimized" style="position: fixed; bottom: 0; right: 0; z-index: 10001; display: none; margin-right: 6em;">';
        minimizeDiv    += '    <div class="card bg-theme border-theme bg-opacity-75 mb-3">';
        minimizeDiv    += '        <div class="card-header border-theme fw-bold small text-inverse">' + $('#' + id + ' .modal-header .modal-title').text() + ' <i style="cursor: pointer;" onclick="$(\'#' + id + '\').modal(\'show\'); $(\'#' + id + '-minimized\').hide();" class="fa-regular fa-window-restore"></i></div>';
        minimizeDiv    += '        <div>';
        minimizeDiv    += '            <div class="card-arrow-bottom-left"></div>';
        minimizeDiv    += '            <div class="card-arrow-bottom-right"></div>';
        minimizeDiv    += '        </div>';
        minimizeDiv    += '    </div>';
        minimizeDiv    += '</div>';

        $('body').append(minimizeDiv);
    }

    $('#' + id + ' .modal-dialog').draggable({
        handle: '.modal-header'
    });

    $('#' + id + ' .modal-header').css('cursor', 'grab');

    $('#' + id).modal('show');

    if (size) {
        $('#' + id + ' .modal-dialog').addClass('modal-' + size);
    }

    if (typeof p.onOpen !== 'undefined') {
        const onOpenFunction = p.onOpen;
        function onOpenCallback(callback)
        {
            callback();
        }
        onOpenCallback(onOpenFunction);
    }

    if (typeof p.onClose !== 'undefined') {
        const onCloseFunction = p.onClose;
        function onCloseCallback(callback)
        {
            callback();
        }

        $('#' + id + ' .btn-close').attr('onclick', '');
        $('#' + id + ' .btn-close').bind('click', function () {
            onCloseCallback(onCloseFunction);
            dialogClose(id);
        });
    }

}
// -------------------------------------------------------------------------------------------
function dialogClose(elm)
{
    if (!elm) {
        console.log('Error: Called dialogClose on no elm');
        return;
    }

    let id = elm;
    if (typeof elm === 'object') {
        id = $('#dialog-modal-container').find('.modal').find(elm).closest('.modal').attr('id');
    }

    if (!$('#' + id).length) {
        return;
    }

    const modal = bootstrap.Modal.getInstance($('#' + id))
    modal.hide();
    $('#' + id).click();
    $('#' + id).remove();

}
// -------------------------------------------------------------------------------------------
