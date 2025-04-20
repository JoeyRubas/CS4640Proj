$('.game-summary').on('click', function () {
    const index = $(this).data('index');
    const detailsRow = $('#details-' + index);
    const icon = $(this).find('.toggle-icon');

    detailsRow.slideToggle(200);
    icon.toggleClass('rotated');
});