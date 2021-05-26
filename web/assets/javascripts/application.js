(function (window, $) {

    $(document).ready(function () {
        renderSeats($('#seats').data('seats'));
    });

    $('#add-group').on('submit', function (event) {
        var $form = $('#add-group'),
            $groupSize = $('#group-size');

        event.preventDefault();

        $.ajax({
            method: 'POST',
            url: $form.attr('action'),
            dataType: 'json',
            data: JSON.stringify({
                numGuests: $groupSize.val()
            })
        }).fail(function (jqXHR, errorText) {
            alert(jqXHR.responseJSON['error'] || 'Unbekannter Fehler')
        }).done(function (responseJSON, jqXHR) {
            renderSeats(responseJSON);
        }).always(function () {
            $groupSize.val('');
        });
    });

    $('#seats').on('click', 'button', function (event) {
        var $btn = $(event.target);

        event.preventDefault();

        $.ajax({
            method: 'DELETE',
            url: '/',
            dataType: 'json',
            data: JSON.stringify({
                groupId: $btn.data('groupId')
            })
        }).fail(function (jqXHR, errorText) {
            alert(jqXHR.responseJSON['error'] || 'Unbekannter Fehler')
        }).done(function (responseJSON, jqXHR) {
            renderSeats(responseJSON);
        });
    })

    function renderSeats(seatData) {
        var $seats = $('#seats tbody'),
            groups = {},
            groupId, groupedSeats,
            $row;

        $seats.empty();
        seatData.forEach(function (groupId, seatIndex) {
            groups[groupId] = groups[groupId] || [];
            groups[groupId].push(seatIndex + 1);
        });
        for (groupId in groups) {
            groupedSeats = groups[groupId];

            $row = $('<tr/>');
            $row.append($('<td/>').text(groupId === 'null' ? 'Freie Plätze' : groupId));
            $row.append($('<td/>').text(groupedSeats.join(', ')));

            if (groupId !== 'null') {
                $row.append($('<td/>')
                    .append(
                        $('<button/>')
                            .text('x')
                            .addClass('btn btn-danger btn-sm')
                            .data('groupId', groupId)
                    ));
            } else {
                $row.append($('<td/>'))
            }

            $seats.append($row);
        }
    }


})(window, jQuery);