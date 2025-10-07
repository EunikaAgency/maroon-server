<?php
/*
Plugin Name: Schema Injector
Plugin URI: https://eunika.agency/
Description: boosts SEO by parsing and injecting FAQ and review schemas into your posts. It hooks into the_content, processes content, and embeds JSON-LD scripts for better search engine visibility.
Version: 1.6
Author: Eunika
Author URI: https://www.linkedin.com/company/eunika-agency/
License: GPL2
*/

// Hook into the_content filter to modify the post content
add_filter('the_content', 'schema_parse_and_inject');

function schema_parse_and_inject($content) {
    // Check if we are in the main loop in a single post

        // Render shortcodes
        $content = do_shortcode($content);

        // Parse FAQ schema from the content
        $faqSchema = parseFaqHtml($content);
        // Parse Review schema from the content
        $reviewSchema = parseReviewHtml($content);
        // Inject schemas into content
        $content .= '<script type="application/ld+json">' . $faqSchema . '</script>';
        $content .= '<script type="application/ld+json">' . $reviewSchema . '</script>';

    return $content;
}

function parseFaqHtml($html) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $faqItems = [];

    // Find all question elements for the first format
    $questionNodes = $xpath->query("//p[contains(@class, 'gb-headline') and contains(@class, 'bg-gray-50')]");

    foreach ($questionNodes as $questionNode) {
        $question = $questionNode->nodeValue;

        // Find the next sibling element that contains the answer
        $answerNode = $questionNode->nextSibling;
        $answerText = '';

        while ($answerNode && $answerNode->nodeType != XML_ELEMENT_NODE) {
            $answerNode = $answerNode->nextSibling;
        }

        // Collect all answer paragraphs
        while ($answerNode && $answerNode->nodeType == XML_ELEMENT_NODE && $answerNode->tagName == 'p' && strpos($answerNode->getAttribute('class'), 'gb-headline') === false) {
            $answerText .= $dom->saveHTML($answerNode) . "\n";
            $answerNode = $answerNode->nextSibling;
        }

        $answerText = trim(strip_tags($answerText));

        if (!empty($answerText)) {
            $faqItems[] = [
                "@type" => "Question",
                "name" => $question,
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $answerText
                ]
            ];
        }
    }

    // Find all accordion elements for the second format
    $accordionNodes = $xpath->query("//div[contains(@class, 'gb-accordion')]");

    foreach ($accordionNodes as $accordionNode) {
        $accordionQuestionNodes = $xpath->query(".//button[contains(@class, 'gb-accordion__toggle')]", $accordionNode);
        
        foreach ($accordionQuestionNodes as $accordionQuestionNode) {
            $question = $accordionQuestionNode->textContent;

            // Find the corresponding answer element
            $answerNode = $accordionQuestionNode->nextSibling;
            while ($answerNode && $answerNode->nodeType != XML_ELEMENT_NODE) {
                $answerNode = $answerNode->nextSibling;
            }

            if ($answerNode && strpos($answerNode->getAttribute('class'), 'gb-accordion__content') !== false) {
                $answerText = '';
                // Extract all paragraphs within the answer element
                $answerParagraphs = $xpath->query(".//p", $answerNode);
                foreach ($answerParagraphs as $answerParagraph) {
                    $answerText .= $answerParagraph->nodeValue . "\n";
                }
                $answerText = trim($answerText);

                if (!empty($answerText)) {
                    $faqItems[] = [
                        "@type" => "Question",
                        "name" => $question,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => $answerText
                        ]
                    ];
                }
            }
        }
    }

    $faqSchema = [
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $faqItems
    ];

    return json_encode($faqSchema, JSON_PRETTY_PRINT);
}

function parseReviewHtml($html) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $reviewItems = [];

    // Find all review elements within the swiper
    $reviewNodes = $xpath->query("//div[contains(@class, 'swiper-slide')]");

    foreach ($reviewNodes as $reviewNode) {
        $customerNameNode = $xpath->query(".//div[contains(@class, 'customer-name')]/span", $reviewNode);
        $ratingNode = $xpath->query(".//div[contains(@class, 'rating')]//img", $reviewNode);
        $contentNode = $xpath->query(".//div[contains(@class, 'content')]/p", $reviewNode);

        if ($customerNameNode->length > 0 && $ratingNode->length > 0 && $contentNode->length > 0) {
            $customerName = $customerNameNode->item(0)->nodeValue;
            $rating = $ratingNode->item(0)->getAttribute('data-src') ?: $ratingNode->item(0)->getAttribute('src');
            preg_match('/stars-(\d)\.svg/', $rating, $matches);
            $ratingValue = isset($matches[1]) ? (int)$matches[1] : 5;
            $content = $contentNode->item(0)->nodeValue;

            $reviewItems[] = [
                "@type" => "Review",
                "author" => $customerName,
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $ratingValue
                ],
                "reviewBody" => $content
            ];
        }
    }

    $reviewSchema = [
        "@context" => "https://schema.org",
        "@type" => "Service",
        "review" => $reviewItems
    ];

    return json_encode($reviewSchema, JSON_PRETTY_PRINT);
}
?>
