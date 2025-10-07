<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Title</title>
</head>

<body>

    <div class="container-fluid p-5">
        <h2>Service Pages</h2>

        <div id="service-pages">

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $.get("http://londonhousecleaners.eunika.agency/wp-json/wp/v2/service-pages", function(data, textStatus, jqXHR) {

                $.each(data, function(index, page) {
                    let container = $('<div></div>'); // Create a div element
                    container.attr('id', page.slug); // Set the ID attribute

                    let pages = $('#service-pages'); // Get the service-pages container
                    pages.append(container); // Append the container

                    $(`#${page.slug}`).append(`<a href="${page.link}" style="color:red; font-weight: bold">${page.title.rendered}</a>`); // Append page title

                    // Fetch page content
                    $.get(page.link, function(pageString, textStatus, jqXHR) {
                        var parsedHTML = $.parseHTML(pageString);
                        var headings = $(parsedHTML).find("h1, h2, h3, h4, h5, h6");

                        headings.each(function() {
                            var tagName = $(this).prop("tagName").toLowerCase();

                            var spacer = '';
                            if (tagName == 'h1') spacer = '&nbsp;';
                            if (tagName == 'h2') spacer = '&nbsp;&nbsp;';
                            if (tagName == 'h3') spacer = '&nbsp;&nbsp;&nbsp;';
                            if (tagName == 'h4') spacer = '&nbsp;&nbsp;&nbsp;&nbsp;';
                            if (tagName == 'h5') spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            if (tagName == 'h6') spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                            var wrappedHeading = `<div>${spacer} <b>${tagName}</b>: ${$(this).text()}</div>`;
                            $(`#${page.slug}`).append(wrappedHeading);

                        });
                    });
                });

            });
        });
    </script>

</body>

</html>