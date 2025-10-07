jQuery(document).ready(function ($) {
    const metaRows = [];

    $('.meta-title').each(function (i, el) {
        const $row = $(el).closest('tr');
        const slug = $row.find('a').eq(1).attr('href');
        metaRows.push({ row: $row, slug });
    });

    async function processSequentially(rows) {
        for (const { row, slug } of rows) {
            const titleEl = row.find('.meta-title');
            const descEl = row.find('.meta-desc');

            titleEl.text('Crawling...').css('color', '');
            descEl.text('Crawling...').css('color', '');

            try {
                const res = await fetch(slug);
                const html = await res.text();

                const titleMatch = html.match(/<title>(.*?)<\/title>/i);
                const descMatch = html.match(/<meta name=["']description["'] content=["'](.*?)["']/i);

                if (titleMatch && titleMatch[1]) {
                    titleEl.text(titleMatch[1]);
                } else {
                    titleEl.text('No title found').css('color', 'red');
                }

                if (descMatch && descMatch[1]) {
                    descEl.text(descMatch[1]);
                } else {
                    descEl.text('No description found').css('color', 'red');
                }
            } catch (err) {
                console.error('Error fetching:', slug, err);
                titleEl.text('Error').css('color', 'red');
                descEl.text('Error').css('color', 'red');
            }
        }
    }

    processSequentially(metaRows);
});
