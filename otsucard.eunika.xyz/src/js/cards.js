var cardsTable;

$(document).ready(function () {
    cardsTable = $("#cardsTable").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        order: [[0, "desc"]],
        dom: '<"d-flex align-items-center justify-content-between mb-4" Bf>rtip',
        // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        buttons: [
            {
                extend: "colvis",
                text: "Show/Hide Columns" // custom label
            }
        ],
        ajax: {
            url: base_url + "cards/ajax_get_cards",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            {
                data: "id",
                visible: false,
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: "card_number",
                render: function (data) {
                    return `<a href='https://otsucard.eunika.xyz/user/profile/${data}' target='_blank'>${data}</a>`;
                }
            },
            {
                data: "status",
                render: function (data) {
                    if (data == 'Pending Activation') return `<span class='text-warning'>${data}</span>`
                    if (data == 'Blocked') return `<span class='text-danger'>${data}</span>`
                    if (data == 'Active') return `<span class='text-success'>${data}</span>`
                    return `<span class='text-info'>${data}</span>`
                }
            },
            {
                data: "fullname",
                render: function (data) {
                    return data ? data : '--';
                }
            },
            {
                data: "email",
                render: function (data) {
                    return data ? data : '--';
                }
            },
            {
                data: "mobile_number",
                render: function (data) {
                    return data ? data : '--';
                }
            },
            {
                data: "role",
                render: function (data) {
                    return data ? data : '--';
                }
            },
            {
                data: "card_image",
                render: function (data) {
                    if (data) return `<img src="${data}" alt="Card" style="width:60px;height:auto;">`
                    return '--';
                }
            },
            {
                data: "created_at",
                render: function (data) {
                    if (data) return moment(data).format('LLL');
                    return '--';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `
                        <a href="${base_url}auth/login_preview/${data.user_id}" class="btn btn-primary btn-xs rounded-pill w-100 mb-1"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                        <div class="d-flex"style="gap: 4px">
                        <button id="showCardQR" class="btn btn-outline-info btn-xs rounded-pill w-100" data-toggle="modal" data-target="#cardTableModal"><i class="fas fa-qrcode"></i></button>
                        <button id="deleteCardBtn" class="btn btn-outline-danger btn-xs rounded-pill w-100"><i class="fas fa-trash    "></i></button>
                        </div>
                    `;

                    return html;
                }
            }
        ],
        createdRow: function (row, data, dataIndex) {
            var cardTableModal = $(row).find('#showCardQR');
            var deleteCardBtn = $(row).find('#deleteCardBtn');

            cardTableModal.click(function () {
                debugger
                const profileUrl = base_url + 'user/profile/' + data.card_number;
                const editUrl = base_url + 'register?activation=' + encodeURIComponent(data.card_number);

                // QR codes
                makeQR($('.modal_card_qr_code_profile'), profileUrl, 'profile_qr_' + data.card_number + '.png');
                makeQR($('.modal_card_qr_code_edit'), editUrl, 'edit_qr_' + data.card_number + '.png');

                debugger
                bindCopy($('.modal_card_qr_link_profile'), profileUrl);
                bindCopy($('.modal_card_qr_link_edit'), editUrl);
            });

            deleteCardBtn.click(function () {
                if (confirm('Are you sure you want to delete this card? This action cannot be undone.')) {
                    $.ajax({
                        type: 'post',
                        url: base_url + 'cards/ajax_delete_card',
                        data: { card_id: data.id },
                        success: function (response) {
                            if (!response || !response.success) {
                                return toastr.error(response.message || 'Unable to delete card');
                            }

                            cardsTable.ajax.reload();
                            toastr.success('Card deleted successfully');

                            setTimeout(() => { window.location.reload(); }, 1500);
                        },
                        error: function () {
                            toastr.error('Request failed');
                        }
                    });
                }
            });

        }
    });

    cardsTable.buttons().container().appendTo('#cardsTable_wrapper .col-md-6:eq(0)');


    function makeQR($box, url, filename) {
        $box.empty();

        // Build QR
        new QRCode($box[0], {
            text: url,
            width: 220,
            height: 220,
            correctLevel: QRCode.CorrectLevel.M
        });

        // Click to download
        $box.off('click').on('click', function () {
            const $img = $(this).find('img').first();
            const $canvas = $(this).find('canvas').first();
            let dataUrl = '';

            if ($canvas.length) {
                try { dataUrl = $canvas[0].toDataURL('image/png'); } catch (e) { }
            }
            if (!dataUrl && $img.length) dataUrl = $img.attr('src');

            if (!dataUrl) return toastr.error('Could not export QR');

            const a = document.createElement('a');
            a.href = dataUrl;
            a.download = filename || 'qrcode.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    }

    function bindCopy($linkEl, url) {
        $linkEl.text(url).attr('href', url).attr('data-url', url);
        $linkEl.off('click').on('click', function (e) {
            e.preventDefault();
            const toCopy = $(this).attr('data-url');
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(toCopy)
                    .then(() => toastr.success('Link copied to clipboard'))
                    .catch(() => fallbackCopy(toCopy));
            } else {
                fallbackCopy(toCopy);
            }
        });
    }

    function fallbackCopy(text) {
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        ta.style.position = 'absolute';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try {
            document.execCommand('copy') ? toastr.success('Link copied to clipboard') : toastr.error('Copy failed');
        } catch (e) {
            toastr.error('Copy failed');
        }
        document.body.removeChild(ta);
    }

    $('#generateNewCardBtn').click(function () {
        $('.qr_label').addClass('d-none');

        $.ajax({
            type: 'post',
            url: base_url + 'cards/ajax_generate_new_card',
            dataType: 'json',
            success: function (response) {
                if (!response || !response.success) {
                    0
                    return toastr.error('Unable to generate new card');
                }

                cardsTable.ajax.reload();

                const profileUrl = base_url + 'user/profile/' + response.card_number;
                const editUrl = base_url + 'register?activation=' + encodeURIComponent(response.card_number);

                debugger
                // QR codes
                makeQR($('.card_qr_code_profile'), profileUrl, 'profile_qr_' + response.card_number + '.png');
                makeQR($('.card_qr_code_edit'), editUrl, 'edit_qr_' + response.card_number + '.png');

                // Links copy to clipboard
                bindCopy($('.card_qr_link_profile'), profileUrl);
                bindCopy($('.card_qr_link_edit'), editUrl);

                $('.qr_label').removeClass('d-none');

                toastr.success('New card generated');
            },
            error: function () {
                toastr.error('Request failed');
            }
        });
    });
});
